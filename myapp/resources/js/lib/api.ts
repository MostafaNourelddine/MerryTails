import axios from "axios";

const API_BASE_URL = "/api";

export interface Category {
    id: number;
    name: string;
    description: string;
    image_path: string;
    created_at: string;
    updated_at: string;
}

export interface Image {
    id: number;
    image_path: string;
    item_id: number;
    created_at: string;
    updated_at: string;
}

export interface Item {
    id: number;
    name: string;
    description: string;
    price: number;
    category_id: number;
    sale: boolean;
    salepercentage: number | null;
    created_at: string;
    updated_at: string;
    category: Category;
    images: Image[];
}

// API functions
export const api = {
    // Get all categories
    getCategories: async (): Promise<Category[]> => {
        const response = await axios.get(`${API_BASE_URL}/categories`);
        return response.data;
    },

    // Get all items with categories and images
    getItems: async (): Promise<Item[]> => {
        const response = await axios.get(`${API_BASE_URL}/items`);
        return response.data;
    },

    // Get items by category
    getItemsByCategory: async (categoryId: number): Promise<Item[]> => {
        const response = await axios.get(
            `${API_BASE_URL}/categories/${categoryId}/items`
        );
        return response.data;
    },
};

