import { Button } from "@/components/ui/button";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { useState, useEffect } from "react";

interface CategoryFilterProps {
    categories: string[];
    selectedCategory: string;
    onCategoryChange: (category: string) => void;
}

const CategoryFilter = ({
    categories,
    selectedCategory,
    onCategoryChange,
}: CategoryFilterProps) => {
    // Ensure unique categories and only a single "All"
    const unique = Array.from(new Set(categories));
    const allCategories = unique.includes("All")
        ? ["All", ...unique.filter((c) => c !== "All")]
        : ["All", ...unique];
    const [startIndex, setStartIndex] = useState(0);
    const [isMobile, setIsMobile] = useState(false);

    // Check if mobile on mount and resize
    useEffect(() => {
        const checkMobile = () => {
            setIsMobile(window.innerWidth < 640);
        };

        checkMobile();
        window.addEventListener("resize", checkMobile);
        return () => window.removeEventListener("resize", checkMobile);
    }, []);

    const VISIBLE_CATEGORIES = isMobile ? 2 : 3;

    // Get visible categories based on current start index
    const visibleCategories = allCategories.slice(
        startIndex,
        startIndex + VISIBLE_CATEGORIES
    );

    // Only auto-adjust on initial load to show "All" category
    useEffect(() => {
        if (selectedCategory === "All" && startIndex !== 0) {
            setStartIndex(0);
        }
    }, [selectedCategory]);

    const goToPrevious = () => {
        if (startIndex > 0) {
            setStartIndex(startIndex - 1);
        }
    };

    const goToNext = () => {
        if (startIndex + VISIBLE_CATEGORIES < allCategories.length) {
            setStartIndex(startIndex + 1);
        }
    };

    const canGoPrevious = startIndex > 0;
    const canGoNext = startIndex + VISIBLE_CATEGORIES < allCategories.length;

    return (
        <div className="flex items-center justify-center mb-8">
            <div className="flex items-center bg-card border border-border rounded-lg p-0.5 sm:p-1 shadow-sm">
                {/* Previous Button */}
                <Button
                    variant="ghost"
                    size="sm"
                    onClick={goToPrevious}
                    disabled={!canGoPrevious}
                    className="h-6 w-6 sm:h-8 sm:w-8 p-0 hover:bg-accent rounded-md disabled:opacity-30"
                >
                    <ChevronLeft className="h-3 w-3 sm:h-4 sm:w-4" />
                </Button>

                {/* Category Items */}
                <div className="flex items-center mx-1 sm:mx-2">
                    {visibleCategories.map((category) => (
                        <Button
                            key={category}
                            variant={
                                selectedCategory === category
                                    ? "default"
                                    : "ghost"
                            }
                            size="sm"
                            onClick={() => onCategoryChange(category)}
                            className={`
                mx-0.5 sm:mx-1 px-2 sm:px-4 py-1 sm:py-2 text-xs sm:text-sm font-medium transition-all duration-300 rounded-md min-w-[80px] sm:min-w-[100px]
                ${
                    selectedCategory === category
                        ? "bg-primary text-primary-foreground shadow-sm"
                        : "text-muted-foreground hover:text-foreground hover:bg-accent"
                }
              `}
                        >
                            {category === "All" ? "All Items" : category}
                        </Button>
                    ))}
                </div>

                {/* Next Button */}
                <Button
                    variant="ghost"
                    size="sm"
                    onClick={goToNext}
                    disabled={!canGoNext}
                    className="h-6 w-6 sm:h-8 sm:w-8 p-0 hover:bg-accent rounded-md disabled:opacity-30"
                >
                    <ChevronRight className="h-3 w-3 sm:h-4 sm:w-4" />
                </Button>
            </div>

            {/* Category indicator dots */}
            <div className="flex items-center ml-4 space-x-1">
                {Array.from({
                    length: Math.ceil(
                        allCategories.length / VISIBLE_CATEGORIES
                    ),
                }).map((_, index) => (
                    <div
                        key={index}
                        className={`h-1.5 w-1.5 rounded-full transition-all duration-300 ${
                            Math.floor(startIndex / VISIBLE_CATEGORIES) ===
                            index
                                ? "bg-primary"
                                : "bg-muted-foreground/30"
                        }`}
                    />
                ))}
            </div>
        </div>
    );
};

export default CategoryFilter;
