<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Users
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@ziegofurniture.com',
            'password' => Hash::make('password'),
            'role'     => 'super_admin',
            'phone'    => '09137652910',
            'company'  => 'Ziego Furniture & Interiors',
            'is_active' => true,
        ]);
        User::create([
            'name'     => 'Store Manager',
            'email'    => 'manager@ziegofurniture.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'is_active' => true,
        ]);
        User::create([
            'name'     => 'John Okafor',
            'email'    => 'customer@example.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '08012345678',
            'company'  => 'Okafor Ventures Ltd',
            'is_active' => true,
        ]);

        // Categories with Unsplash images
        $categoryData = [
            ['name' => 'Living Room',  'description' => 'Sofas, coffee tables, TV stands and more',          'image' => 'https://images.unsplash.com/photo-1555041469-9b86f7c9c3dd?w=600&q=80&fit=crop'],
            ['name' => 'Bedroom',      'description' => 'Beds, wardrobes, nightstands and dressers',         'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80&fit=crop'],
            ['name' => 'Dining Room',  'description' => 'Dining tables, chairs and display cabinets',        'image' => 'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?w=600&q=80&fit=crop'],
            ['name' => 'Office',       'description' => 'Executive desks, office chairs, filing cabinets',   'image' => 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=600&q=80&fit=crop'],
            ['name' => 'Outdoor',      'description' => 'Garden furniture, patio sets and outdoor decor',    'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80&fit=crop'],
            ['name' => 'Kitchen',      'description' => 'Kitchen cabinets, stools and kitchen islands',      'image' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80&fit=crop'],
        ];

        $cats = [];
        foreach ($categoryData as $i => $cat) {
            $cats[$cat['name']] = Category::create([
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'description' => $cat['description'],
                'image'       => $cat['image'],
                'sort_order'  => $i,
                'is_active'   => true,
            ]);
        }

        // Product definitions: [name, price, sale_price|null, category, material, color, dimensions, featured, stock, wholesale, min_qty, image_url]
        $products = [
            // ── LIVING ROOM (12) ──────────────────────────────────────────────────────
            ['Royal 3-Seater Sofa',           180000, null,   'Living Room', 'Velvet Fabric',      'Grey/Cream',     '220cm x 90cm x 80cm', true,  8,  false, 1, 'https://images.unsplash.com/photo-1555041469-9b86f7c9c3dd?w=800&q=80&fit=crop'],
            ['Luxury L-Shape Corner Sofa',    320000, 290000, 'Living Room', 'Premium Leather',    'Chocolate Brown', '280cm x 200cm x 85cm', true, 5,  true,  1, 'https://images.unsplash.com/photo-1586023492157-ac6decaa0b0c?w=800&q=80&fit=crop'],
            ['Accent Armchair',                65000, null,   'Living Room', 'Boucle Fabric',      'Cream/Gold',     '75cm x 80cm x 90cm',  false, 15, false, 1, 'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=800&q=80&fit=crop'],
            ['Wooden Coffee Table',            45000, 38000,  'Living Room', 'Solid Walnut',       'Natural Brown',  '120cm x 60cm x 45cm', false, 20, false, 1, 'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?w=800&q=80&fit=crop'],
            ['TV Entertainment Unit',          95000, null,   'Living Room', 'MDF/Glass',          'White/Oak',      '180cm x 45cm x 55cm', false, 12, false, 1, 'https://images.unsplash.com/photo-1558997519-83ea9252edf8?w=800&q=80&fit=crop'],
            ['Chesterfield 2-Seater',         145000, null,   'Living Room', 'Full-Grain Leather', 'Burgundy',       '175cm x 80cm x 80cm', true,  6,  false, 1, 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&q=80&fit=crop'],
            ['Modular Sofa Set (5-Seater)',   480000, 420000, 'Living Room', 'Linen Blend',        'Beige/Grey',     '320cm x 180cm x 80cm', false, 3, true,  2, 'https://images.unsplash.com/photo-1555041469-9b86f7c9c3dd?w=800&q=80&fit=crop'],
            ['Glass-Top Side Table',           28000, null,   'Living Room', 'Tempered Glass',     'Clear/Chrome',   '45cm x 45cm x 55cm', false, 25, false, 1, 'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?w=800&q=80&fit=crop'],
            ['Floor Lamp Stand',               18000, null,   'Living Room', 'Metal/Fabric',       'Gold/White',     '170cm tall',          false, 30, false, 1, 'https://images.unsplash.com/photo-1586023492157-ac6decaa0b0c?w=800&q=80&fit=crop'],
            ['Bookshelf (5-Tier)',             72000, 65000,  'Living Room', 'Solid Pine',         'Walnut',         '80cm x 30cm x 180cm', false, 10, false, 1, 'https://images.unsplash.com/photo-1558997519-83ea9252edf8?w=800&q=80&fit=crop'],
            ['Reception Lounge Set',          380000, 350000, 'Living Room', 'Leather & Chrome',   'Black',          '3-piece set',         true,  3,  true,  1, 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&q=80&fit=crop'],
            ['Ottoman Storage Bench',          42000, null,   'Living Room', 'Fabric',             'Navy Blue',      '110cm x 45cm x 45cm', false, 18, false, 1, 'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=800&q=80&fit=crop'],

            // ── BEDROOM (10) ──────────────────────────────────────────────────────────
            ['King Size Bed Frame',           320000, null,   'Bedroom',     'Solid Oak',          'Dark Walnut',    '200cm x 180cm x 120cm', true,  5, false, 1, 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80&fit=crop'],
            ['Queen Size Upholstered Bed',    240000, 210000, 'Bedroom',     'Velvet Headboard',   'Dusty Pink',     '160cm x 200cm x 130cm', true, 7, false, 1, 'https://images.unsplash.com/photo-1505693314120-0d443867891c?w=800&q=80&fit=crop'],
            ['4-Door Sliding Wardrobe',       280000, null,   'Bedroom',     'MDF with Mirror',    'White/Mirror',   '240cm x 60cm x 220cm', false, 7, false, 1, 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=800&q=80&fit=crop'],
            ['6-Drawer Chest of Drawers',      85000, 75000,  'Bedroom',     'Solid Wood',         'Antique White',  '90cm x 45cm x 110cm', false, 12, false, 1, 'https://images.unsplash.com/photo-1588854337236-6889d631faa8?w=800&q=80&fit=crop'],
            ['Bedside Table (Set of 2)',        55000, null,   'Bedroom',     'MDF/Lacquer',        'Oak/White',      '45cm x 40cm x 55cm',  false, 20, false, 1, 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80&fit=crop'],
            ['Dressing Table with Mirror',    120000, 105000, 'Bedroom',     'Solid Wood',         'Champagne Gold', '120cm x 45cm x 150cm', false, 8, false, 1, 'https://images.unsplash.com/photo-1505693314120-0d443867891c?w=800&q=80&fit=crop'],
            ['Complete Bedroom Suite',        680000, 620000, 'Bedroom',     'Premium Mahogany',   'Dark Mahogany',  '5-piece set',         true,  2,  true,  1, 'https://images.unsplash.com/photo-1588854337236-6889d631faa8?w=800&q=80&fit=crop'],
            ['Single Bunk Bed (Kids)',         95000, null,   'Bedroom',     'Steel/MDF',          'White/Grey',     '100cm x 200cm x 170cm', false,10, false, 1, 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=800&q=80&fit=crop'],
            ['Walk-In Closet System',         450000, null,   'Bedroom',     'MDF Panels',         'White Matt',     'Custom sizing',       false, 3,  true,  1, 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=800&q=80&fit=crop'],
            ['Vanity Stool',                   22000, null,   'Bedroom',     'Velvet/Metal',       'Blush Pink',     '40cm x 40cm x 48cm',  false, 25, false, 1, 'https://images.unsplash.com/photo-1505693314120-0d443867891c?w=800&q=80&fit=crop'],

            // ── DINING ROOM (8) ───────────────────────────────────────────────────────
            ['6-Seater Teak Dining Set',      420000, null,   'Dining Room', 'Teak Wood',          'Natural Teak',   '180cm x 90cm x 76cm', true,  4,  true,  1, 'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?w=800&q=80&fit=crop'],
            ['8-Seater Glass Dining Table',   380000, 340000, 'Dining Room', 'Tempered Glass',     'Black/Clear',    '200cm x 100cm x 76cm', false, 3, true,  1, 'https://images.unsplash.com/photo-1567538096630-e97773dcc7ce?w=800&q=80&fit=crop'],
            ['Dining Chair (set of 6)',        180000, null,   'Dining Room', 'Fabric/Wood',        'Grey/Oak',       '45cm x 50cm x 90cm',  false, 10, true,  6, 'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?w=800&q=80&fit=crop'],
            ['Bar Stool (set of 4)',            95000, 85000,  'Dining Room', 'Leather/Metal',      'Caramel/Chrome', '40cm x 40cm x 75cm',  false, 8,  false, 4, 'https://images.unsplash.com/photo-1567538096630-e97773dcc7ce?w=800&q=80&fit=crop'],
            ['China Cabinet/Display Unit',    165000, null,   'Dining Room', 'Solid Wood/Glass',   'Dark Oak',       '120cm x 45cm x 200cm', false, 5, false, 1, 'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?w=800&q=80&fit=crop'],
            ['Round Marble Dining Table',     520000, 480000, 'Dining Room', 'Marble/Brass',       'White/Gold',     '130cm diameter x 76cm', true, 2, false, 1, 'https://images.unsplash.com/photo-1567538096630-e97773dcc7ce?w=800&q=80&fit=crop'],
            ['Buffet/Sideboard',              145000, null,   'Dining Room', 'Engineered Wood',    'Walnut/Matt Black','160cm x 45cm x 80cm', false, 6, false, 1, 'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?w=800&q=80&fit=crop'],
            ['4-Seater Compact Dining Set',   185000, 165000, 'Dining Room', 'Rubber Wood',        'White/Beige',    '120cm x 75cm x 76cm', false, 7,  false, 1, 'https://images.unsplash.com/photo-1567538096630-e97773dcc7ce?w=800&q=80&fit=crop'],

            // ── OFFICE (10) ───────────────────────────────────────────────────────────
            ['Executive High-Back Chair',      85000, null,   'Office',      'Premium Leather',    'Black/Brown',    '70cm x 70cm x 120cm', true,  20, false, 1, 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=800&q=80&fit=crop'],
            ['L-Shaped Executive Desk',       250000, 220000, 'Office',      'Mahogany Veneer',    'Dark Brown',     '180cm x 150cm x 75cm', true, 10, false, 1, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=800&q=80&fit=crop'],
            ['Conference Table (10-seat)',     650000, null,   'Office',      'Walnut Veneer',      'Walnut/Chrome',  '300cm x 120cm x 75cm', false, 3, true,  1, 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=800&q=80&fit=crop'],
            ['Ergonomic Mesh Chair',           55000, 48000,  'Office',      'Mesh/Nylon',         'Black',          '65cm x 65cm x 115cm', false, 35, true,  5, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=800&q=80&fit=crop'],
            ['4-Drawer Filing Cabinet',        48000, null,   'Office',      'Steel',              'Graphite Grey',  '47cm x 62cm x 132cm', false, 25, true,  3, 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=800&q=80&fit=crop'],
            ['Manager Standing Desk',         145000, 125000, 'Office',      'Engineered Wood',    'White/Silver',   '140cm x 70cm x 75-120cm', false,8, false,1, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=800&q=80&fit=crop'],
            ['Reception Counter Desk',        280000, null,   'Office',      'MDF/Laminate',       'White/Chrome',   '180cm x 70cm x 110cm', false, 4, true,  1, 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=800&q=80&fit=crop'],
            ['Bookcase/Storage Cabinet',       68000, null,   'Office',      'Particle Board',     'White/Beech',    '90cm x 30cm x 190cm', false, 15, false, 1, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=800&q=80&fit=crop'],
            ['Visitor Chair (set of 4)',        96000, 85000,  'Office',      'Fabric/Metal',       'Charcoal/Silver','52cm x 55cm x 80cm',  false, 12, true,  4, 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=800&q=80&fit=crop'],
            ['Complete Office Bundle (10)',   980000, 880000, 'Office',      'Mixed Premium',      'Black/Walnut',   'Full office setup',   true,  2,  true,  1, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=800&q=80&fit=crop'],

            // ── OUTDOOR (5) ───────────────────────────────────────────────────────────
            ['6-Piece Rattan Patio Set',      265000, 240000, 'Outdoor',     'PE Rattan/Aluminium','Brown/Cream',    '4 chairs + table + sofa', true, 5, false, 1, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80&fit=crop'],
            ['Garden Swing Chair',             85000, null,   'Outdoor',     'Steel/Polyester',    'Beige',          '120cm x 90cm x 160cm', false,10, false, 1, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&q=80&fit=crop'],
            ['Outdoor Dining Set (4-seat)',   180000, null,   'Outdoor',     'Teak/Acacia',        'Natural Wood',   '120cm x 80cm x 75cm', false, 6,  false, 1, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80&fit=crop'],
            ['Sun Lounger (pair)',             120000, 105000, 'Outdoor',     'Aluminium/Textilene','Charcoal/Grey',  '195cm x 70cm x 35cm', false, 8,  false, 2, 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&q=80&fit=crop'],
            ['Outdoor Bar Set',               145000, null,   'Outdoor',     'Rattan/Metal',       'Dark Brown',     '2 stools + bar table', false, 4, true,  1, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80&fit=crop'],

            // ── KITCHEN (5) ───────────────────────────────────────────────────────────
            ['Kitchen Island with Storage',   195000, 175000, 'Kitchen',     'Solid Wood/Steel',   'White/Oak',      '120cm x 60cm x 90cm', true,  5,  false, 1, 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&q=80&fit=crop'],
            ['Kitchen Bar Stool (set of 2)',   48000, null,   'Kitchen',     'Metal/Leather',      'Black/Chrome',   '40cm x 40cm x 75cm',  false, 20, false, 2, 'https://images.unsplash.com/photo-1556909172-54557c7e4fb7?w=800&q=80&fit=crop'],
            ['Wall-Mounted Cabinet Set',      145000, 130000, 'Kitchen',     'MDF/Melamine',       'Glossy White',   '180cm x 30cm x 60cm', false, 8,  true,  1, 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&q=80&fit=crop'],
            ['Kitchen Trolley/Cart',           38000, null,   'Kitchen',     'Stainless Steel',    'Silver',         '80cm x 45cm x 90cm',  false, 15, false, 1, 'https://images.unsplash.com/photo-1556909172-54557c7e4fb7?w=800&q=80&fit=crop'],
            ['Full Kitchen Cabinet Set',      850000, 780000, 'Kitchen',     'Marine Ply/MDF',     'White/Marble',   'Custom modular set',  true,  2,  true,  1, 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&q=80&fit=crop'],
        ];

        foreach ($products as $i => [$name, $price, $salePrice, $catName, $material, $color, $dims, $featured, $stock, $wholesale, $minQty, $imageUrl]) {
            $product = Product::create([
                'name'              => $name,
                'slug'              => Str::slug($name) . '-' . ($i + 1),
                'price'             => $price,
                'sale_price'        => $salePrice,
                'category_id'       => $cats[$catName]->id,
                'material'          => $material,
                'color'             => $color,
                'dimensions'        => $dims,
                'featured'          => $featured,
                'stock'             => $stock,
                'is_wholesale'      => $wholesale,
                'min_order_qty'     => $minQty,
                'status'            => 'active',
                'short_description' => 'Premium quality furniture crafted to perfection for your home and office needs.',
                'description'       => 'This premium piece is crafted using the finest materials available, combining aesthetics with durability. Designed for both comfort and style, it brings elegance to any space. Perfect for bulk corporate orders and home furnishing alike.',
                'sku'               => 'ZFI-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'path'       => $imageUrl,
                'alt'        => $name,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        // Testimonials
        $testimonials = [
            ['name' => 'Alhaji Musa Ibrahim',   'company' => 'Musa Group of Companies',      'rating' => 5, 'content' => 'We furnished all 12 offices with Ziego and the quality is exceptional. Their bulk pricing saved us over 30% and delivery was nationwide within 5 days. Highly recommended!'],
            ['name' => 'Mrs. Adunola Taiwo',     'company' => 'Taiwo & Associates Law Firm',  'rating' => 5, 'content' => 'The executive office set we ordered transformed our workspace completely. Clients always compliment the furniture. Ziego delivers exactly what they promise — quality that speaks style!'],
            ['name' => 'Mr. Emeka Okonkwo',      'company' => 'Lagos State Ministry',         'rating' => 5, 'content' => 'Ordered 50 office chairs and 25 conference tables for our new building. The wholesale pricing was unbeatable and every piece arrived in perfect condition. Five stars!'],
            ['name' => 'Chief Bola Adeyemi',     'company' => 'Adeyemi Hospitality Group',    'rating' => 5, 'content' => 'Furnished 3 hotels with Ziego Furniture. The 3D showroom feature helped us visualize everything before ordering. Excellent service and truly world-class quality.'],
            ['name' => 'Dr. Ngozi Okafor',       'company' => 'Okafor Medical Centre',        'rating' => 5, 'content' => 'Our clinic waiting area and doctor offices look completely professional now. The team was responsive and delivery to Enugu was on time. Will definitely order again!'],
            ['name' => 'Pastor Samuel Adisa',    'company' => 'Grace Chapel International',   'rating' => 5, 'content' => 'We needed 200 chairs for our new church building. Ziego gave us the best wholesale deal and delivered everything to Ibadan without any hassle. God bless them!'],
        ];

        foreach ($testimonials as $i => $t) {
            Testimonial::create(array_merge($t, ['is_active' => true, 'sort_order' => $i]));
        }
    }
}
