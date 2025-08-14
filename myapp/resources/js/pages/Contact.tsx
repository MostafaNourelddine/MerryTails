import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Phone, MapPin, Instagram } from "lucide-react";

const Contact = () => {
    return (
        <div className="min-h-screen bg-background py-12">
            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-12">
                    <h1 className="text-4xl font-bold text-foreground mb-4">
                        Contact Us
                    </h1>
                    <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
                        Have questions about our handmade crochet items? We'd
                        love to hear from you!
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {/* Contact Information */}
                    <Card className="bg-card border-border shadow-[var(--shadow-card)]">
                        <CardHeader>
                            <CardTitle className="text-primary text-xl font-semibold">
                                Get in Touch
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-6">
                            <div className="flex items-start space-x-4">
                                <div className="bg-primary-soft p-3 rounded-lg">
                                    <Phone className="h-5 w-5 text-primary" />
                                </div>
                                <div>
                                    <h3 className="font-semibold text-foreground">
                                        Phone
                                    </h3>
                                    <p className="text-muted-foreground">
                                        +961 81 906 983
                                    </p>
                                    <p className="text-sm text-muted-foreground">
                                        Call us for custom orders and inquiries
                                    </p>
                                </div>
                            </div>

                            <div className="flex items-start space-x-4">
                                <div className="bg-primary-soft p-3 rounded-lg">
                                    <Instagram className="h-5 w-5 text-primary" />
                                </div>
                                <div>
                                    <h3 className="font-semibold text-foreground">
                                        Instagram
                                    </h3>
                                    <p className="text-muted-foreground">
                                        @merry_tails
                                    </p>
                                    <p className="text-sm text-muted-foreground">
                                        Follow us for updates and new creations
                                    </p>
                                </div>
                            </div>

                            <div className="flex items-start space-x-4">
                                <div className="bg-primary-soft p-3 rounded-lg">
                                    <MapPin className="h-5 w-5 text-primary" />
                                </div>
                                <div>
                                    <h3 className="font-semibold text-foreground">
                                        Address
                                    </h3>
                                    <p className="text-muted-foreground">
                                        Jwayya, Al Janub
                                        <br />
                                        Lebanon
                                    </p>
                                    <p className="text-sm text-muted-foreground">
                                        Visit our workshop for in-person
                                        consultations
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    {/* About Our Craft */}
                    <Card className="bg-card border-border shadow-[var(--shadow-card)]">
                        <CardHeader>
                            <CardTitle className="text-primary text-xl font-semibold">
                                About Our Craft
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <p className="text-muted-foreground">
                                Welcome to MerryTails, where every stitch tells
                                a story of passion and dedication. Our handmade
                                crochet items are crafted with love and
                                attention to detail, using only the finest
                                materials.
                            </p>
                            <p className="text-muted-foreground">
                                From cozy blankets that warm your home to
                                delicate baby items that celebrate new
                                beginnings, each piece is unique and made to
                                order. We take pride in our traditional
                                techniques while embracing modern designs.
                            </p>
                            <p className="text-muted-foreground">
                                Whether you're looking for a special gift or
                                something beautiful for your own home, we're
                                here to help you find the perfect handmade
                                treasure.
                            </p>

                            <div className="mt-6 p-4 bg-primary-soft rounded-lg border border-primary/20">
                                <h4 className="font-semibold text-foreground mb-2">
                                    Custom Orders Welcome!
                                </h4>
                                <p className="text-sm text-muted-foreground">
                                    Have a specific color or pattern in mind? We
                                    love creating custom pieces. Contact us to
                                    discuss your vision and we'll bring it to
                                    life!
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
};

export default Contact;
