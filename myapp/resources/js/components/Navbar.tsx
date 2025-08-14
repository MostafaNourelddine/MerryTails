import { useState } from "react";
import { Link, useLocation } from "react-router-dom";
import { Search, Menu, X } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";

interface NavbarProps {
    onSearch: (query: string) => void;
    searchQuery: string;
}

const Navbar = ({ onSearch, searchQuery }: NavbarProps) => {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const location = useLocation();

    const isActive = (path: string) => location.pathname === path;

    return (
        <nav className="sticky top-0 z-50 bg-card/95 backdrop-blur-md border-b border-border shadow-sm">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center h-16">
                    {/* Logo */}
                    <Link
                        to="/"
                        className="text-2xl font-bold text-primary hover:text-primary-hover transition-colors"
                    >
                        MerryTails
                    </Link>

                    {/* Desktop Navigation */}
                    <div className="hidden md:flex items-center space-x-8">
                        <Link
                            to="/"
                            className={`text-sm font-medium transition-colors hover:text-primary ${
                                isActive("/")
                                    ? "text-primary"
                                    : "text-muted-foreground"
                            }`}
                        >
                            Home
                        </Link>
                        <Link
                            to="/contact"
                            className={`text-sm font-medium transition-colors hover:text-primary ${
                                isActive("/contact")
                                    ? "text-primary"
                                    : "text-muted-foreground"
                            }`}
                        >
                            Contact
                        </Link>
                    </div>

                    {/* Search Bar - Desktop */}
                    <div className="hidden md:flex items-center space-x-4">
                        <div className="relative">
                            <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground h-4 w-4" />
                            <Input
                                type="text"
                                placeholder="Search crochet items..."
                                value={searchQuery}
                                onChange={(e) => onSearch(e.target.value)}
                                className="pl-10 w-64 bg-input/50 border-border focus:bg-input"
                            />
                        </div>
                    </div>

                    {/* Mobile Menu Button */}
                    <Button
                        variant="ghost"
                        size="sm"
                        className="md:hidden"
                        onClick={() => setIsMenuOpen(!isMenuOpen)}
                    >
                        {isMenuOpen ? (
                            <X className="h-5 w-5" />
                        ) : (
                            <Menu className="h-5 w-5" />
                        )}
                    </Button>
                </div>

                {/* Mobile Menu */}
                {isMenuOpen && (
                    <div className="md:hidden border-t border-border bg-card/95 backdrop-blur-md">
                        <div className="px-2 pt-2 pb-3 space-y-1">
                            <Link
                                to="/"
                                className={`block px-3 py-2 text-sm font-medium transition-colors hover:text-primary ${
                                    isActive("/")
                                        ? "text-primary"
                                        : "text-muted-foreground"
                                }`}
                                onClick={() => setIsMenuOpen(false)}
                            >
                                Home
                            </Link>
                            <Link
                                to="/contact"
                                className={`block px-3 py-2 text-sm font-medium transition-colors hover:text-primary ${
                                    isActive("/contact")
                                        ? "text-primary"
                                        : "text-muted-foreground"
                                }`}
                                onClick={() => setIsMenuOpen(false)}
                            >
                                Contact
                            </Link>

                            {/* Mobile Search */}
                            <div className="px-3 py-2">
                                <div className="relative">
                                    <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground h-4 w-4" />
                                    <Input
                                        type="text"
                                        placeholder="Search crochet items..."
                                        value={searchQuery}
                                        onChange={(e) =>
                                            onSearch(e.target.value)
                                        }
                                        className="pl-10 w-full bg-input/50 border-border focus:bg-input"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </nav>
    );
};

export default Navbar;
