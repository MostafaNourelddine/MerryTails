import { Card, CardContent } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";

interface ProductCardProps {
    id: string;
    name: string;
    category: string;
    price: string;
    image: string;
    description: string;
    onClick?: () => void;
}

const ProductCard = ({
    name,
    category,
    price,
    image,
    description,
    onClick,
}: ProductCardProps) => {
    return (
        <Card
            className="group cursor-pointer overflow-hidden bg-card border-border hover:shadow-[var(--shadow-card)] transition-all duration-300 hover:-translate-y-1"
            onClick={onClick}
        >
            <div className="aspect-square overflow-hidden bg-gradient-to-br from-primary-soft to-primary">
                <img
                    src={image}
                    alt={name}
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
            </div>
            <CardContent className="p-2 sm:p-4">
                <div className="flex items-center justify-between mb-1 sm:mb-2">
                    <Badge
                        variant="secondary"
                        className="text-xs px-1 py-0.5 sm:px-2 sm:py-1"
                    >
                        {category}
                    </Badge>
                    <span className="text-sm sm:text-lg font-semibold text-primary">
                        {price}
                    </span>
                </div>
                <h3 className="font-semibold text-foreground mb-1 sm:mb-2 text-sm sm:text-base group-hover:text-primary transition-colors line-clamp-1 sm:line-clamp-none">
                    {name}
                </h3>
                <p className="text-xs sm:text-sm text-muted-foreground line-clamp-2">
                    {description}
                </p>
            </CardContent>
        </Card>
    );
};

export default ProductCard;
