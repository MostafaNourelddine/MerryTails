import { useEffect, useState } from "react";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { ChevronLeft, ChevronRight, X } from "lucide-react";

interface Product {
    id: string;
    name: string;
    category: string;
    price: string;
    image: string;
    images: string[];
    description: string;
    fullDescription: string;
}

interface ProductDetailProps {
    product: Product | null;
    isOpen: boolean;
    onClose: () => void;
}

const ProductDetail = ({ product, isOpen, onClose }: ProductDetailProps) => {
    if (!product) return null;

    const [currentImageIndex, setCurrentImageIndex] = useState(0);

    // Reset image index when product changes
    useEffect(() => {
        setCurrentImageIndex(0);
    }, [product?.id]);

    const nextImage = () => {
        setCurrentImageIndex((prev) => (prev + 1) % product.images.length);
    };

    const prevImage = () => {
        setCurrentImageIndex(
            (prev) => (prev - 1 + product.images.length) % product.images.length
        );
    };

    const mainImage = product.images[currentImageIndex] ?? product.image;

    return (
        <Dialog open={isOpen} onOpenChange={onClose}>
            <DialogContent className="w-[90vw] max-w-[400px] sm:max-w-2xl md:max-w-3xl max-h-[85vh] sm:max-h-[90vh] overflow-y-auto bg-background border-border p-3 sm:p-4 md:p-6">
                <DialogHeader className="pb-3 sm:pb-4">
                    <DialogTitle className="text-lg sm:text-xl md:text-2xl font-bold text-foreground leading-tight">
                        {product.name}
                    </DialogTitle>
                </DialogHeader>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 md:gap-8">
                    {/* Image Gallery */}
                    <div className="space-y-3 sm:space-y-4">
                        <div className="relative overflow-hidden rounded-lg bg-gray-50 dark:bg-gray-900">
                            <img
                                src={mainImage}
                                alt={`${product.name} - Image ${
                                    currentImageIndex + 1
                                }`}
                                className="w-full h-auto object-contain"
                                style={{
                                    maxHeight: "min(40vh, 300px)",
                                    minHeight: "200px",
                                }}
                            />

                            {product.images.length > 1 && (
                                <>
                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        className="absolute left-1 sm:left-2 top-1/2 -translate-y-1/2 bg-background/90 hover:bg-background z-10 rounded-full shadow-sm"
                                        style={{ width: 36, height: 36 }}
                                        onClick={prevImage}
                                    >
                                        <ChevronLeft className="h-4 w-4 sm:h-5 sm:w-5" />
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="icon"
                                        className="absolute right-1 sm:right-2 top-1/2 -translate-y-1/2 bg-background/90 hover:bg-background z-10 rounded-full shadow-sm"
                                        style={{ width: 36, height: 36 }}
                                        onClick={nextImage}
                                    >
                                        <ChevronRight className="h-4 w-4 sm:h-5 sm:w-5" />
                                    </Button>
                                </>
                            )}
                        </div>
                    </div>

                    {/* Product Info */}
                    <div className="space-y-4 sm:space-y-6">
                        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
                            <Badge
                                variant="secondary"
                                className="text-xs sm:text-sm w-fit"
                            >
                                {product.category}
                            </Badge>
                            <span className="text-xl sm:text-2xl font-bold text-primary">
                                {product.price}
                            </span>
                        </div>

                        <div>
                            <h3 className="text-base sm:text-lg font-semibold text-foreground mb-2 sm:mb-3">
                                Description
                            </h3>
                            <p className="text-sm sm:text-base text-muted-foreground leading-relaxed whitespace-normal break-words">
                                {product.fullDescription}
                            </p>
                        </div>

                        <div className="space-y-3 sm:space-y-4 pt-3 sm:pt-4 border-t border-border">
                            <h4 className="text-sm sm:text-base font-semibold text-foreground">
                                Product Details
                            </h4>
                            <ul className="space-y-1.5 sm:space-y-2 text-xs sm:text-sm text-muted-foreground">
                                <li>• Handmade with premium materials</li>
                                <li>
                                    • Made to order - allow 5-7 days for
                                    creation
                                </li>
                                <li>
                                    • Care instructions included with purchase
                                </li>
                                <li>• Custom colors available upon request</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    );
};

export default ProductDetail;
