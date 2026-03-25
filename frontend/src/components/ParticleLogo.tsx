import React, { useEffect, useRef } from 'react';
import darkLogoSrc from '../assets/1__1.svg';
import lightLogoSrc from '../assets/logo-white-mode.svg';
import { useTheme } from './ThemeProvider';

const LOGO_VIEWBOX_WIDTH = 1640;
const LOGO_VIEWBOX_HEIGHT = 1012;
const LOGO_SYMBOL_PATH_COUNT = 2;

const ParticleLogo: React.FC = () => {
  const canvasRef = useRef<HTMLCanvasElement>(null);
  const { theme } = useTheme();

  useEffect(() => {
    const canvas = canvasRef.current;
    if (!canvas) return;
    const ctx = canvas.getContext('2d', { alpha: true });
    if (!ctx) return;

    let width = window.innerWidth;
    let height = window.innerHeight;
    canvas.width = width;
    canvas.height = height;

    const logoWidth = Math.min(800, width * 0.9);
    const logoHeight = Math.min(logoWidth * (LOGO_VIEWBOX_HEIGHT / LOGO_VIEWBOX_WIDTH), height * 0.55);
    
    const hCanvas = document.createElement('canvas');
    hCanvas.width = logoWidth;
    hCanvas.height = logoHeight;
    const hCtx = hCanvas.getContext('2d', { willReadFrequently: true });

    const particles: any[] = [];
    let isDisposed = false;
    let objectUrl: string | null = null;
    const logoSrc = theme === 'light' ? lightLogoSrc : darkLogoSrc;
    const isLightTheme = theme === 'light';

    const buildParticles = async () => {
      if (!hCtx || isDisposed) return;

      hCtx.clearRect(0, 0, logoWidth, logoHeight);

      const response = await fetch(logoSrc);
      const svgMarkup = await response.text();
      if (isDisposed) return;

      const parser = new DOMParser();
      const svgDoc = parser.parseFromString(svgMarkup, 'image/svg+xml');
      const svgRoot = svgDoc.documentElement;
      const allPaths = Array.from(svgRoot.querySelectorAll('path'));

      allPaths.slice(LOGO_SYMBOL_PATH_COUNT).forEach((path) => path.remove());

      const serializer = new XMLSerializer();
      const symbolMarkup = serializer.serializeToString(svgRoot);
      const svgBlob = new Blob([symbolMarkup], { type: 'image/svg+xml' });

      if (objectUrl) {
        URL.revokeObjectURL(objectUrl);
      }
      objectUrl = URL.createObjectURL(svgBlob);

      const logoImage = new Image();
      logoImage.onload = () => {
        if (isDisposed) return;

        hCtx.clearRect(0, 0, logoWidth, logoHeight);
        hCtx.drawImage(logoImage, 0, 0, logoWidth, logoHeight);

        const imgData = hCtx.getImageData(0, 0, logoWidth, logoHeight).data;
        const step = width < 768 ? 6 : 4;

        particles.length = 0;

        for (let y = 0; y < logoHeight; y += step) {
          for (let x = 0; x < logoWidth; x += step) {
            const index = (y * logoWidth + x) * 4;
            const alpha = imgData[index + 3];
            if (alpha > 128) {
              const r = imgData[index];
              const g = imgData[index + 1];
              const b = imgData[index + 2];
              particles.push({
                originX: x - logoWidth / 2,
                originY: y - logoHeight / 2,
                color: `rgb(${r},${g},${b})`,
                angleOffset: Math.random() * Math.PI * 2,
                scatterRadius: Math.random() * Math.max(width, height) * 0.4 + 50,
                rotationSpeed: (Math.random() - 0.5) * 0.5,
                floatSpeedX: Math.random() * 0.8 + 0.2,
                floatSpeedY: Math.random() * 0.8 + 0.2,
                floatOffsetX: Math.random() * Math.PI * 2,
                floatOffsetY: Math.random() * Math.PI * 2,
                floatAmplitude: isLightTheme ? Math.random() * 1.5 + 0.35 : Math.random() * 2 + 0.5,
                baseSize: isLightTheme ? Math.random() * 0.95 + 0.65 : Math.random() * 0.6 + 0.2,
                alpha: isLightTheme ? 0.95 : 1,
              });
            }
          }
        }
      };

      logoImage.src = objectUrl;
    };

    void buildParticles();

    let animationFrameId: number;
    let scrollProgress = 0;
    let targetScrollProgress = 0;

    const handleScroll = () => {
      const scrollY = window.scrollY;
      const maxScroll = document.body.scrollHeight - window.innerHeight;
      targetScrollProgress = Math.max(0, Math.min(1, scrollY / maxScroll));
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();

    let mouseX = -1000;
    let mouseY = -1000;
    const handleMouseMove = (e: MouseEvent) => {
      mouseX = e.clientX;
      mouseY = e.clientY;
    };
    window.addEventListener('mousemove', handleMouseMove);

    const render = () => {
      scrollProgress += (targetScrollProgress - scrollProgress) * 0.08;
      const time = Date.now() * 0.001;

      ctx.clearRect(0, 0, width, height);

      let dispersion = 0;
      if (scrollProgress < 0.05) {
        dispersion = 0;
      } else if (scrollProgress > 0.95) {
        dispersion = 0;
      } else {
        const mapped = (scrollProgress - 0.05) / 0.9;
        dispersion = Math.sin(mapped * Math.PI);
        dispersion = Math.pow(dispersion, 0.7); // Adjust curve for more time dispersed
      }

      const centerX = width / 2;
      const centerY = height / 2;

      particles.forEach(p => {
        const angle = dispersion * Math.PI * 2 * p.rotationSpeed;
        const currentRadius = dispersion * p.scatterRadius;

        const targetX = centerX + p.originX;
        const targetY = centerY + p.originY;

        const dispersedX = centerX + Math.cos(p.angleOffset + angle) * currentRadius;
        const dispersedY = centerY + Math.sin(p.angleOffset + angle) * currentRadius;

        // Add continuous floating motion
        const floatX = Math.sin(time * p.floatSpeedX + p.floatOffsetX) * p.floatAmplitude;
        const floatY = Math.cos(time * p.floatSpeedY + p.floatOffsetY) * p.floatAmplitude;

        // Blend floating motion with dispersion (less float when dispersed)
        let x = targetX + (dispersedX - targetX) * dispersion + floatX * (1 - dispersion * 0.5);
        let y = targetY + (dispersedY - targetY) * dispersion + floatY * (1 - dispersion * 0.5);

        const dx = mouseX - x;
        const dy = mouseY - y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        const maxDist = 200; // Increased interaction radius
        
        if (dist > 0 && dist < maxDist) {
          const force = Math.pow((maxDist - dist) / maxDist, 2);
          x -= (dx / dist) * force * 60; // Increased repulsion force
          y -= (dy / dist) * force * 60;
        }

        // Pulse size slightly
        const pulseAmplitude = isLightTheme ? 0.3 : 0.5;
        const currentSize = p.baseSize + Math.sin(time * 3 + p.floatOffsetX) * pulseAmplitude;

        ctx.fillStyle = p.color;
        ctx.globalAlpha = p.alpha;
        ctx.beginPath();
        ctx.arc(x, y, Math.max(0.1, currentSize), 0, Math.PI * 2);
        ctx.fill();
      });

      ctx.globalAlpha = 1;

      animationFrameId = requestAnimationFrame(render);
    };

    render();

    const handleResize = () => {
      width = window.innerWidth;
      height = window.innerHeight;
      canvas.width = width;
      canvas.height = height;
    };
    window.addEventListener('resize', handleResize);

    return () => {
      isDisposed = true;
      if (objectUrl) {
        URL.revokeObjectURL(objectUrl);
      }
      window.removeEventListener('scroll', handleScroll);
      window.removeEventListener('mousemove', handleMouseMove);
      window.removeEventListener('resize', handleResize);
      cancelAnimationFrame(animationFrameId);
    };
  }, [theme]);

  return (
    <canvas
      ref={canvasRef}
      className="fixed inset-0 pointer-events-none z-10"
    />
  );
};

export default ParticleLogo;
