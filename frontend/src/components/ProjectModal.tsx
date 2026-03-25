import React from 'react';
import { X, ArrowRight } from 'lucide-react';
import { useTranslation } from 'react-i18next';

export interface Project {
  id: number;
  title: string;
  category: string | null;
  image: string | null;
  description: string | null;
}

interface ProjectModalProps {
  project: Project | null;
  onClose: () => void;
}

export default function ProjectModal({ project, onClose }: ProjectModalProps) {
  const { t, i18n } = useTranslation();

  if (!project) return null;

  return (
    <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" dir={i18n.language === 'ar' ? 'rtl' : 'ltr'}>
      <div 
        className="overlay-scrim absolute inset-0 transition-opacity"
        onClick={onClose}
      ></div>
      
      <div className="modal-surface relative w-full max-w-4xl border rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row animate-in fade-in zoom-in-95 duration-300">
        <button 
          onClick={onClose}
          className={`absolute top-4 ${i18n.language === 'ar' ? 'left-4' : 'right-4'} z-20 p-2 bg-black/50 hover:bg-black text-white rounded-full backdrop-blur-md transition-colors`}
        >
          <X size={20} />
        </button>
        
        <div className="w-full md:w-1/2 h-64 md:h-auto relative">
          <img 
            src={project.image || 'https://picsum.photos/seed/sarab-project/1200/900'} 
            alt={project.title} 
            className="absolute inset-0 w-full h-full object-cover"
            referrerPolicy="no-referrer"
          />
          <div className={`project-overlay absolute inset-0 ${i18n.language === 'ar' ? 'md:bg-gradient-to-l' : 'md:bg-gradient-to-r'}`}></div>
        </div>
        
        <div className="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center relative z-10">
          <span className="text-cyan-400 font-semibold tracking-wider uppercase text-sm mb-2">
            {project.category || 'Project'}
          </span>
          <h3 className="text-3xl md:text-4xl font-bold mb-6">
            {project.title}
          </h3>
          <p className="muted-text text-lg leading-relaxed mb-8">
            {project.description || 'No description provided yet.'}
          </p>
          
          <button className="flex items-center gap-2 font-semibold group w-fit">
            <span className="group-hover:text-cyan-400 transition-colors">{t('modal.view_live')}</span>
            <ArrowRight size={20} className={`transform ${i18n.language === 'ar' ? 'group-hover:-translate-x-1 rotate-180' : 'group-hover:translate-x-1'} group-hover:text-cyan-400 transition-all`} />
          </button>
        </div>
      </div>
    </div>
  );
}
