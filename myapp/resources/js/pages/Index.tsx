import { useState, useMemo } from "react";
import { useQuery } from "@tanstack/react-query";
import { Button } from "@/components/ui/button";
import ProductCard from "@/components/ProductCard";
import CategoryFilter from "@/components/CategoryFilter";
import ProductDetail from "@/components/ProductDetail";
import { Heart, Scissors, Star, Sparkles } from "lucide-react";
import { api, type Item, type Category } from "@/lib/api";

// Convert Item to Product format for compatibility
const convertItemToProduct = (item: Item) => ({
    id: item.id.toString(),
    name: item.name,
    category: item.category.name,
    price: `$${item.price}`,
    image:
        item.images.length > 0
            ? getImageUrl(item.images[0].image_path)
            : "/placeholder-image.jpg",
    images: item.images.map((img) => getImageUrl(img.image_path)),
    description: item.description,
    fullDescription: item.description, // Using description as full description for now
});

// Helper function to get image URL
const getImageUrl = (imagePath: string) => {
    if (!imagePath) return "/placeholder-image.jpg";
    if (imagePath.startsWith("http")) return imagePath;
    // Categories are stored directly in public/categories/, items are in storage
    if (imagePath.startsWith("categories/")) {
        return `/${imagePath}`;
    }
    return `/storage/${imagePath}`;
};

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

interface IndexProps {
    searchQuery: string;
    selectedCategory: string;
    onCategoryChange: (category: string) => void;
}

const ITEMS_PER_PAGE = 8;

const Index = ({
    searchQuery,
    selectedCategory,
    onCategoryChange,
}: IndexProps) => {
    const [visibleItems, setVisibleItems] = useState(ITEMS_PER_PAGE);
    const [selectedProduct, setSelectedProduct] = useState<Product | null>(
        null
    );

    // Fetch data from API
    const {
        data: items = [],
        isLoading: itemsLoading,
        error: itemsError,
    } = useQuery({
        queryKey: ["items"],
        queryFn: api.getItems,
    });

    const { data: categories = [], isLoading: categoriesLoading } = useQuery({
        queryKey: ["categories"],
        queryFn: api.getCategories,
    });

    // Convert items to products
    const products: Product[] = items.map(convertItemToProduct);

    // Get unique category names
    const categoryNames = ["All", ...categories.map((cat) => cat.name)];

    const filteredProducts = useMemo(() => {
        return products.filter((product) => {
            const matchesSearch =
                product.name
                    .toLowerCase()
                    .includes(searchQuery.toLowerCase()) ||
                product.description
                    .toLowerCase()
                    .includes(searchQuery.toLowerCase());
            const matchesCategory =
                selectedCategory === "All" ||
                product.category === selectedCategory;
            return matchesSearch && matchesCategory;
        });
    }, [products, searchQuery, selectedCategory]);

    const displayedProducts = filteredProducts.slice(0, visibleItems);
    const hasMoreItems = visibleItems < filteredProducts.length;

    const loadMore = () => {
        setVisibleItems((prev) => Math.min(prev + 5, filteredProducts.length));
    };

    // Reset visible items when category or search changes
    useMemo(() => {
        setVisibleItems(ITEMS_PER_PAGE);
    }, [selectedCategory, searchQuery]);

    // Loading states
    if (itemsLoading || categoriesLoading) {
        return (
            <div className="min-h-screen bg-background p-8">
                <div className="flex items-center justify-center h-64">
                    <div className="text-center">
                        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-4"></div>
                        <p className="text-muted-foreground">
                            Loading products...
                        </p>
                    </div>
                </div>
            </div>
        );
    }

    // Error state
    if (itemsError) {
        return (
            <div className="min-h-screen bg-background p-8">
                <div className="flex items-center justify-center h-64">
                    <div className="text-center">
                        <p className="text-destructive mb-4">
                            Error loading products
                        </p>
                        <Button onClick={() => window.location.reload()}>
                            Try Again
                        </Button>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-background">
            {/* Hero Section */}
            <section className="bg-gradient-to-br from-primary-soft via-background to-primary/10 py-20">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <div className="flex justify-center items-center space-x-2 mb-6">
                        <Heart className="h-8 w-8 text-primary" />
                        <Scissors className="h-8 w-8 text-primary" />
                        <Star className="h-8 w-8 text-primary" />
                    </div>
                    <h1 className="text-5xl md:text-6xl font-bold text-foreground mb-6">
                        MerryTails
                    </h1>
                    <p className="text-xl md:text-2xl text-muted-foreground mb-8 max-w-3xl mx-auto">
                        Handmade with love, crafted with passion. Discover
                        unique crochet treasures that bring warmth and beauty to
                        your world.
                    </p>
                </div>
            </section>

            {/* Full Width Announcement Banner */}
            <section className="relative w-full bg-primary/90 backdrop-blur-sm overflow-hidden">
                {/* Background Pattern */}
                <div className="absolute inset-0 bg-gradient-to-r from-primary/95 via-primary/85 to-primary/95"></div>
                <div className="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(255,255,255,0.1),transparent_70%)]"></div>

                {/* Floating Elements */}
                <div className="absolute top-4 left-1/4 animate-bounce">
                    <Sparkles className="h-6 w-6 text-primary-foreground/40" />
                </div>
                <div
                    className="absolute bottom-4 right-1/4 animate-bounce"
                    style={{ animationDelay: "1s" }}
                >
                    <Heart className="h-5 w-5 text-primary-foreground/30" />
                </div>
                <div className="absolute top-8 right-1/3 animate-pulse">
                    <Star className="h-4 w-4 text-primary-foreground/50" />
                </div>

                <div className="relative z-10 py-12 px-4">
                    <div className="max-w-4xl mx-auto text-center">
                        {/* Main Announcement */}
                        <div className="mb-6">
                            <div className="inline-flex items-center bg-primary-foreground/20 rounded-full px-6 py-2 mb-4">
                                <Sparkles className="h-4 w-4 text-primary-foreground mr-2" />
                                <span className="text-sm font-medium text-primary-foreground tracking-wide uppercase">
                                    Handcrafted Excellence
                                </span>
                            </div>

                            <h2 className="text-3xl md:text-5xl font-bold text-primary-foreground mb-4 leading-tight">
                                Artisan Quality
                                <span className="block text-primary-foreground/90">
                                    Premium Materials
                                </span>
                            </h2>

                            <p className="text-lg md:text-xl text-primary-foreground/80 mb-6 max-w-2xl mx-auto">
                                Experience the difference of truly handmade
                                craftsmanship. Every piece is thoughtfully
                                created with attention to detail and built to
                                last a lifetime.
                            </p>
                        </div>

                        {/* Call to Action */}
                        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <Button
                                size="lg"
                                className="bg-primary-foreground text-primary hover:bg-primary-foreground/90 font-semibold px-8 py-3 rounded-full shadow-lg cursor-default"
                            >
                                Explore Our Collection
                                <Star className="h-4 w-4 ml-2" />
                            </Button>

                            <div className="flex items-center text-primary-foreground/80 text-sm">
                                <Heart className="h-4 w-4 mr-1" />
                                <span>Made with love, delivered with care</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Products Section */}
            <section className="py-16">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl md:text-4xl font-bold text-foreground mb-4">
                            Our Beautiful Collection
                        </h2>
                        <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                            Each piece is lovingly handcrafted with premium
                            materials and attention to detail
                        </p>
                    </div>

                    {/* Category Filter */}
                    <CategoryFilter
                        categories={categoryNames}
                        selectedCategory={selectedCategory}
                        onCategoryChange={onCategoryChange}
                    />

                    {/* Product Grid */}
                    {filteredProducts.length > 0 ? (
                        <>
                            <div className="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                                {displayedProducts.map((product) => (
                                    <ProductCard
                                        key={product.id}
                                        {...product}
                                        onClick={() =>
                                            setSelectedProduct(product)
                                        }
                                    />
                                ))}
                            </div>

                            {/* Load More Button */}
                            {filteredProducts.length > visibleItems &&
                                filteredProducts.length > 0 && (
                                    <div className="text-center mt-12">
                                        <Button
                                            onClick={loadMore}
                                            variant="outline"
                                            size="lg"
                                            className="border-primary text-primary hover:bg-primary hover:text-primary-foreground px-8"
                                        >
                                            Load More Items (
                                            {filteredProducts.length -
                                                visibleItems}{" "}
                                            remaining)
                                        </Button>
                                    </div>
                                )}
                        </>
                    ) : (
                        <div className="text-center py-12">
                            <p className="text-lg text-muted-foreground">
                                No items found matching your search. Try a
                                different search term or category.
                            </p>
                        </div>
                    )}
                </div>
            </section>

            {/* Beautiful Footer */}
            <footer className="bg-gradient-to-r from-primary-soft via-background to-primary-soft py-16">
                <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center">
                        {/* Brand Name */}
                        <div className="mb-8">
                            <h2 className="text-5xl md:text-6xl font-serif font-bold bg-gradient-to-r from-primary via-primary-hover to-primary bg-clip-text text-transparent mb-4">
                                MerryTails
                            </h2>
                            <div className="flex items-center justify-center space-x-3 mb-4">
                                <div className="h-px w-12 bg-primary"></div>
                                <Heart className="h-5 w-5 text-primary" />
                                <div className="h-px w-12 bg-primary"></div>
                            </div>
                            <p className="text-lg text-muted-foreground italic">
                                "Weaving happiness, one stitch at a time"
                            </p>
                        </div>

                        {/* Details */}
                        <div className="grid md:grid-cols-3 gap-8 mb-8">
                            <div>
                                <h4 className="font-semibold text-foreground mb-3">
                                    Our Story
                                </h4>
                                <p className="text-sm text-muted-foreground">
                                    Born from a passion for handmade beauty,
                                    MerryTails creates unique crochet pieces
                                    that bring warmth and joy to every home.
                                </p>
                            </div>
                            <div>
                                <h4 className="font-semibold text-foreground mb-3">
                                    Quality Promise
                                </h4>
                                <p className="text-sm text-muted-foreground">
                                    Every piece is crafted with premium
                                    materials and endless love, ensuring lasting
                                    beauty and comfort for years to come.
                                </p>
                            </div>
                            <div>
                                <h4 className="font-semibold text-foreground mb-3">
                                    Custom Orders
                                </h4>
                                <p className="text-sm text-muted-foreground">
                                    Have a special vision? We love bringing
                                    unique ideas to life. Contact us to discuss
                                    your custom crochet dreams.
                                </p>
                            </div>
                        </div>

                        {/* Final Touch */}
                        <div className="pt-8 border-t border-border/50">
                            <p className="text-sm text-muted-foreground">
                                © 2024 MerryTails. Handcrafted with ❤️ • All
                                rights reserved
                            </p>
                        </div>
                    </div>
                </div>
            </footer>

            {/* Product Detail Modal */}
            <ProductDetail
                product={selectedProduct}
                isOpen={!!selectedProduct}
                onClose={() => setSelectedProduct(null)}
            />
        </div>
    );
};

export default Index;
