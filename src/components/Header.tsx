import { Menu, X } from 'lucide-react';
import { useState } from 'react';

type Page = 'home' | 'about' | 'contact' | 'admin';

interface HeaderProps {
  currentPage: Page;
  setCurrentPage: (page: Page) => void;
}

export default function Header({ currentPage, setCurrentPage }: HeaderProps) {
  const [isMenuOpen, setIsMenuOpen] = useState(false);

  const navItems = [
    { name: 'Home', page: 'home' as Page },
    { name: 'About', page: 'about' as Page },
    { name: 'Contact Us', page: 'contact' as Page },
  ];

  const handleNavClick = (page: Page) => {
    setCurrentPage(page);
    setIsMenuOpen(false);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <header className="bg-white shadow-md sticky top-0 z-50">
      <nav className="container mx-auto px-4 py-4">
        <div className="flex items-center justify-between">
          <div 
            className="text-2xl font-bold text-blue-600 cursor-pointer"
            onClick={() => handleNavClick('home')}
          >
            Business Solutions
          </div>

          {/* Desktop Navigation */}
          <ul className="hidden md:flex space-x-8">
            {navItems.map((item) => (
              <li key={item.page}>
                <button
                  onClick={() => handleNavClick(item.page)}
                  className={`text-lg font-medium transition-colors ${
                    currentPage === item.page
                      ? 'text-blue-600'
                      : 'text-gray-700 hover:text-blue-600'
                  }`}
                >
                  {item.name}
                </button>
              </li>
            ))}
          </ul>

          {/* Mobile Menu Button */}
          <button
            className="md:hidden text-gray-700"
            onClick={() => setIsMenuOpen(!isMenuOpen)}
          >
            {isMenuOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>

        {/* Mobile Navigation */}
        {isMenuOpen && (
          <ul className="md:hidden mt-4 space-y-2">
            {navItems.map((item) => (
              <li key={item.page}>
                <button
                  onClick={() => handleNavClick(item.page)}
                  className={`block w-full text-left py-2 px-4 rounded transition-colors ${
                    currentPage === item.page
                      ? 'bg-blue-600 text-white'
                      : 'text-gray-700 hover:bg-gray-100'
                  }`}
                >
                  {item.name}
                </button>
              </li>
            ))}
          </ul>
        )}
      </nav>
    </header>
  );
}
