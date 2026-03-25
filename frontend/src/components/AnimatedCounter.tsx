import React, { useEffect, useRef } from 'react';
import { useInView, animate } from 'motion/react';

interface AnimatedCounterProps {
  value: number;
}

export default function AnimatedCounter({ value }: AnimatedCounterProps) {
  const ref = useRef<HTMLSpanElement>(null);
  const isInView = useInView(ref, { once: true, margin: "-50px" });

  useEffect(() => {
    if (isInView && ref.current) {
      const controls = animate(0, value, {
        duration: 2.5,
        ease: "easeOut",
        onUpdate: (v) => {
          if (ref.current) {
            ref.current.textContent = Math.round(v).toLocaleString();
          }
        }
      });
      return () => controls.stop();
    }
  }, [isInView, value]);

  return <span ref={ref}>0</span>;
}
