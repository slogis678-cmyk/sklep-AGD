export interface Product {
  id: string;
  name: string;
  category: string;
  subcategory: string;
  price: number;
  originalPrice?: number;
  rating: number;
  reviews: number;
  image: string;
  badge?: string;
  badgeColor?: string;
  description: string;
  brand: string;
  inStock: boolean;
  isNew?: boolean;
  isBestseller?: boolean;
}

export interface Category {
  id: string;
  name: string;
  slug: string;
  icon: string;
  image: string;
  subcategories: string[];
  productCount: number;
}

export const categories: Category[] = [
  {
    id: 'agd',
    name: 'AGD',
    slug: 'agd',
    icon: 'Refrigerator',
    image: 'https://images.pexels.com/photos/6636288/pexels-photo-6636288.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    subcategories: ['Pralki', 'Lodówki', 'Zmywarki', 'Piekarniki', 'Mikrofalówki', 'Odkurzacze', 'Ekspressy do kawy'],
    productCount: 1240,
  },
  {
    id: 'elektronika',
    name: 'Elektronika',
    slug: 'elektronika',
    icon: 'Laptop',
    image: 'https://images.pexels.com/photos/4006158/pexels-photo-4006158.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    subcategories: ['Laptopy', 'Smartfony', 'Tablety', 'Telewizory', 'Słuchawki', 'Aparaty', 'Akcesoria'],
    productCount: 2380,
  },
  {
    id: 'meble',
    name: 'Meble',
    slug: 'meble',
    icon: 'Sofa',
    image: 'https://images.pexels.com/photos/6980724/pexels-photo-6980724.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    subcategories: ['Sofy i kanapy', 'Łóżka', 'Szafy', 'Stoły i krzesła', 'Biurka', 'Komody', 'Półki'],
    productCount: 890,
  },
];

export const products: Product[] = [
  // AGD
  {
    id: 'agd-1',
    name: 'Pralka Samsung EcoBubble 9kg',
    category: 'agd',
    subcategory: 'Pralki',
    price: 2199,
    originalPrice: 2799,
    rating: 4.7,
    reviews: 324,
    image: 'https://images.pexels.com/photos/28479466/pexels-photo-28479466.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: '-21%',
    badgeColor: 'red',
    description: 'Energooszczędna pralka z technologią EcoBubble, ładowność 9kg, klasa A.',
    brand: 'Samsung',
    inStock: true,
    isBestseller: true,
  },
  {
    id: 'agd-2',
    name: 'Lodówka Bosch KGN Combi 350L',
    category: 'agd',
    subcategory: 'Lodówki',
    price: 3499,
    originalPrice: 3899,
    rating: 4.8,
    reviews: 198,
    image: 'https://images.pexels.com/photos/8082207/pexels-photo-8082207.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: 'Nowość',
    badgeColor: 'blue',
    description: 'Lodówka dwudrzwiowa z NoFrost, pojemność 350L, klasa energetyczna A++.',
    brand: 'Bosch',
    inStock: true,
    isNew: true,
  },
  {
    id: 'agd-3',
    name: 'Ekspres do kawy DeLonghi Magnifica',
    category: 'agd',
    subcategory: 'Ekspressy do kawy',
    price: 1899,
    originalPrice: 2399,
    rating: 4.9,
    reviews: 512,
    image: 'https://images.pexels.com/photos/19599329/pexels-photo-19599329.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: '-21%',
    badgeColor: 'red',
    description: 'Automatyczny ekspres ciśnieniowy z wbudowanym młynkiem, 15 bar.',
    brand: 'DeLonghi',
    inStock: true,
    isBestseller: true,
  },
  {
    id: 'agd-4',
    name: 'Zmywarka Siemens SN75EX11CE',
    category: 'agd',
    subcategory: 'Zmywarki',
    price: 2799,
    rating: 4.6,
    reviews: 147,
    image: 'https://images.pexels.com/photos/213162/pexels-photo-213162.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    description: 'Zmywarka do zabudowy, 14 nakryć, klasa A+++, WiFi.',
    brand: 'Siemens',
    inStock: true,
  },
  // Elektronika
  {
    id: 'el-1',
    name: 'Laptop Apple MacBook Air M3 13"',
    category: 'elektronika',
    subcategory: 'Laptopy',
    price: 5999,
    originalPrice: 6499,
    rating: 4.9,
    reviews: 876,
    image: 'https://images.pexels.com/photos/8989524/pexels-photo-8989524.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: 'Top',
    badgeColor: 'amber',
    description: 'Ultrabook z procesorem M3, 8GB RAM, 256GB SSD, wyświetlacz Retina.',
    brand: 'Apple',
    inStock: true,
    isBestseller: true,
  },
  {
    id: 'el-2',
    name: 'Smartfon Samsung Galaxy S24 Ultra',
    category: 'elektronika',
    subcategory: 'Smartfony',
    price: 4899,
    originalPrice: 5499,
    rating: 4.8,
    reviews: 1203,
    image: 'https://images.pexels.com/photos/11129922/pexels-photo-11129922.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: '-11%',
    badgeColor: 'red',
    description: 'Flagowy smartfon z AI, 200MP aparat, S Pen, 12GB/256GB.',
    brand: 'Samsung',
    inStock: true,
    isBestseller: true,
  },
  {
    id: 'el-3',
    name: 'Telewizor LG OLED 55" 4K',
    category: 'elektronika',
    subcategory: 'Telewizory',
    price: 4299,
    originalPrice: 5299,
    rating: 4.9,
    reviews: 432,
    image: 'https://images.pexels.com/photos/6980724/pexels-photo-6980724.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: '-19%',
    badgeColor: 'red',
    description: 'TV OLED 55 cali, 4K 120Hz, HDR, Dolby Atmos, webOS.',
    brand: 'LG',
    inStock: true,
  },
  {
    id: 'el-4',
    name: 'Słuchawki Sony WH-1000XM5',
    category: 'elektronika',
    subcategory: 'Słuchawki',
    price: 1399,
    originalPrice: 1699,
    rating: 4.8,
    reviews: 967,
    image: 'https://images.pexels.com/photos/4006158/pexels-photo-4006158.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: 'Bestseller',
    badgeColor: 'green',
    description: 'Bezprzewodowe słuchawki ANC, 30h baterii, LDAC, Bluetooth 5.2.',
    brand: 'Sony',
    inStock: true,
    isBestseller: true,
  },
  // Meble
  {
    id: 'meb-1',
    name: 'Sofa narożna Velvet 3+2',
    category: 'meble',
    subcategory: 'Sofy i kanapy',
    price: 3299,
    originalPrice: 4199,
    rating: 4.7,
    reviews: 89,
    image: 'https://images.pexels.com/photos/11671088/pexels-photo-11671088.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: '-21%',
    badgeColor: 'red',
    description: 'Sofa narożna tapicerowana tkaniną Velvet, funkcja spania, pojemnik.',
    brand: 'HomeStyle',
    inStock: true,
  },
  {
    id: 'meb-2',
    name: 'Łóżko drewniane Scandic 160x200',
    category: 'meble',
    subcategory: 'Łóżka',
    price: 2199,
    originalPrice: 2699,
    rating: 4.6,
    reviews: 134,
    image: 'https://images.pexels.com/photos/29012619/pexels-photo-29012619.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: 'Nowość',
    badgeColor: 'blue',
    description: 'Łóżko z litego drewna dębowego, pojemnik na pościel, wieniec 160x200.',
    brand: 'Scandic',
    inStock: true,
    isNew: true,
  },
  {
    id: 'meb-3',
    name: 'Biurko narożne Flex Pro 150cm',
    category: 'meble',
    subcategory: 'Biurka',
    price: 1499,
    originalPrice: 1899,
    rating: 4.5,
    reviews: 56,
    image: 'https://images.pexels.com/photos/6580377/pexels-photo-6580377.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    description: 'Narożne biurko do home office, z regulacją wysokości, USB-C, 150x120cm.',
    brand: 'WorkSpace',
    inStock: true,
  },
  {
    id: 'meb-4',
    name: 'Szafa przesuwna Nordic 250cm',
    category: 'meble',
    subcategory: 'Szafy',
    price: 3899,
    rating: 4.4,
    reviews: 72,
    image: 'https://images.pexels.com/photos/6580377/pexels-photo-6580377.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    description: 'Szafa z drzwiami przesuwnymi, 250x220cm, system organizacji wnętrza.',
    brand: 'Nordic Home',
    inStock: false,
  },
];

export const featuredBanners = [
  {
    id: 'b1',
    title: 'Letnia Wyprzedaż AGD',
    subtitle: 'Oszczędź do 30% na sprzętach AGD',
    cta: 'Sprawdź ofertę',
    image: 'https://images.pexels.com/photos/6636288/pexels-photo-6636288.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: 'Do -30%',
    color: 'from-blue-900 to-blue-700',
    category: 'agd',
  },
  {
    id: 'b2',
    title: 'Nowa Elektronika 2025',
    subtitle: 'Najnowsze laptopy, smartfony i TV',
    cta: 'Zobacz nowości',
    image: 'https://images.pexels.com/photos/4006158/pexels-photo-4006158.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: 'Nowości',
    color: 'from-slate-900 to-slate-700',
    category: 'elektronika',
  },
  {
    id: 'b3',
    title: 'Urządź Dom z Klasą',
    subtitle: 'Meble skandynawskie z dostawą w 48h',
    cta: 'Wybierz meble',
    image: 'https://images.pexels.com/photos/11671088/pexels-photo-11671088.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
    badge: 'Dostawa 48h',
    color: 'from-emerald-900 to-emerald-700',
    category: 'meble',
  },
];
