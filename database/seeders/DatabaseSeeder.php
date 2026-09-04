<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Specification;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ----------------------------------------------------
        // 0. Admin User
        // ----------------------------------------------------
        \App\Models\User::query()->firstOrCreate(
            ['email' => 'admin@magneticpowerbattery.com'],
            [
                'name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // ----------------------------------------------------
        // 0.5 Banners
        // ----------------------------------------------------
        $bannersData = [
            [
                'title' => 'High-Performance Lithium Batteries',
                'subtitle' => 'Powering the future of electric mobility with unmatched efficiency.',
                'image' => 'banners/banner.png',
                'button_text' => 'Explore Products',
                'button_url' => '/products',
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'Advanced BMS Technology',
                'subtitle' => 'Ensuring safety, longevity, and peak performance for every cell.',
                'image' => 'banners/banner.png',
                'button_text' => 'Learn More',
                'button_url' => '/about',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Commercial E-Rickshaw Packs',
                'subtitle' => 'Heavy-duty power solutions built for maximum endurance.',
                'image' => 'banners/banner.png',
                'button_text' => 'Get a Quote',
                'button_url' => '/contact',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($bannersData as $bannerData) {
            \App\Models\Banner::query()->firstOrCreate(['title' => $bannerData['title']], $bannerData);
        }

        // ----------------------------------------------------
        // 1. Categories
        // ----------------------------------------------------
        $categoriesData = [
            ['slug' => 'lfp-48v-series', 'name' => '48V LFP Series', 'description' => 'High-performance 48V Lithium Iron Phosphate (LFP) battery packs.', 'is_active' => true, 'sort_order' => 0],
            ['slug' => 'lfp-51v-series', 'name' => '51.2V LFP Series', 'description' => 'Robust 51.2V LFP batteries, ideal for E-Rickshaws and commercial use.', 'is_active' => true, 'sort_order' => 1],
            ['slug' => 'lfp-60v-series', 'name' => '60.8V LFP Series', 'description' => 'Powerful 60.8V LFP batteries designed for high-speed electric scooters.', 'is_active' => true, 'sort_order' => 2],
            ['slug' => 'lfp-72v-series', 'name' => '72V LFP Series', 'description' => 'Maximum range 72V (73.2V/73.6V) LFP batteries for performance EVs.', 'is_active' => true, 'sort_order' => 3],
        ];

        foreach ($categoriesData as $cat) {
            Category::query()->firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // ----------------------------------------------------
        // 2. Brands
        // ----------------------------------------------------
        $brandsData = [
            ['slug' => 'magnetic-power', 'name' => 'Magnetic Power', 'description' => 'Magnetic Power Battery — Professional Lithium-ion Battery Manufacturer.', 'is_active' => true, 'sort_order' => 0],
            ['slug' => 'eco-drive', 'name' => 'EcoDrive', 'description' => 'Eco-friendly and highly efficient battery series for urban mobility.', 'is_active' => true, 'sort_order' => 1],
        ];

        foreach ($brandsData as $brand) {
            Brand::query()->firstOrCreate(['slug' => $brand['slug']], $brand);
        }

        // ----------------------------------------------------
        // 3. Applications
        // ----------------------------------------------------
        $applicationsData = [
            ['slug' => 'electric-scooters', 'name' => 'Electric Scooters', 'description' => 'Battery packs designed for 2-wheeler electric scooters.', 'is_active' => true, 'sort_order' => 0],
            ['slug' => 'electric-rickshaws', 'name' => 'Electric Rickshaws', 'description' => 'High-capacity battery packs for 3-wheeler e-rickshaws.', 'is_active' => true, 'sort_order' => 1],
            ['slug' => 'solar-energy', 'name' => 'Solar Energy', 'description' => 'Energy storage batteries for solar panel systems.', 'is_active' => true, 'sort_order' => 2],
            ['slug' => 'ups-inverters', 'name' => 'UPS & Inverters', 'description' => 'Backup power batteries for home and office UPS systems.', 'is_active' => true, 'sort_order' => 3],
            ['slug' => 'electric-bicycles', 'name' => 'Electric Bicycles', 'description' => 'Lightweight batteries for e-bikes and pedelecs.', 'is_active' => true, 'sort_order' => 4],
        ];

        foreach ($applicationsData as $app) {
            Application::query()->firstOrCreate(['slug' => $app['slug']], $app);
        }

        // ----------------------------------------------------
        // 4. Specifications
        // ----------------------------------------------------
        $specsData = [
            ['name' => 'Nominal Voltage', 'unit' => 'V', 'is_active' => true, 'sort_order' => 0],
            ['name' => 'Nominal Capacity', 'unit' => 'Ah', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Energy', 'unit' => 'Wh', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Continuous Discharge Current', 'unit' => 'A', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Peak Discharge Current', 'unit' => 'A', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'Charge Voltage', 'unit' => 'V', 'is_active' => true, 'sort_order' => 5],
            ['name' => 'Cycle Life', 'unit' => 'Cycles', 'is_active' => true, 'sort_order' => 6],
            ['name' => 'Weight', 'unit' => 'Kg', 'is_active' => true, 'sort_order' => 7],
            ['name' => 'Dimensions (L x W x H)', 'unit' => 'mm', 'is_active' => true, 'sort_order' => 8],
            ['name' => 'BMS Rating', 'unit' => 'A', 'is_active' => true, 'sort_order' => 9],
        ];

        foreach ($specsData as $spec) {
            Specification::query()->firstOrCreate(['name' => $spec['name']], $spec);
        }

        // ----------------------------------------------------
        // 5. Products
        // ----------------------------------------------------
                $cat48 = Category::where('slug', 'lfp-48v-series')->first();
        $cat51 = Category::where('slug', 'lfp-51v-series')->first();
        $cat60 = Category::where('slug', 'lfp-60v-series')->first();
        $cat72 = Category::where('slug', 'lfp-72v-series')->first();
        $brandMain = Brand::where('slug', 'magnetic-power')->first();

        // Fetch or create necessary specifications
        $specPower = Specification::firstOrCreate(['name' => 'Power Output'], ['unit' => 'W', 'is_active' => true]);
        $specWarranty = Specification::firstOrCreate(['name' => 'Warranty'], ['unit' => 'Years', 'is_active' => true]);
        $specRange = Specification::firstOrCreate(['name' => 'Estimated Range'], ['unit' => 'km', 'is_active' => true]);
        $specCycleLife = Specification::firstOrCreate(['name' => 'Cycle Life'], ['unit' => 'Cycles', 'is_active' => true]);
        $specChemistry = Specification::firstOrCreate(['name' => 'Chemistry'], ['unit' => '', 'is_active' => true]);
        $specWeight = Specification::firstOrCreate(['name' => 'Weight'], ['unit' => 'Kg', 'is_active' => true]);

        if ($brandMain) {
            $sourceImages = [
                public_path('images/product.png'),
                public_path('images/product2.png'),
                public_path('images/product3.png'),
            ];

            $targetDir = storage_path('app/public/products');
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $batteries = [
                ['voltage' => '48', 'capacity' => '30', 'watt' => '1440', 'warranty' => '4', 'range' => '55-60', 'weight' => '18', 'cat' => $cat48],
                ['voltage' => '48', 'capacity' => '45', 'watt' => '1920', 'warranty' => '4', 'range' => '80-90', 'weight' => '22', 'cat' => $cat48],
                ['voltage' => '51.2', 'capacity' => '30', 'watt' => '1536', 'warranty' => '4', 'range' => '60-65', 'weight' => '19', 'cat' => $cat51],
                ['voltage' => '51.2', 'capacity' => '45', 'watt' => '2304', 'warranty' => '4', 'range' => '85-100', 'weight' => '24', 'cat' => $cat51],
                ['voltage' => '60.8', 'capacity' => '30', 'watt' => '1824', 'warranty' => '4', 'range' => '65-80', 'weight' => '21', 'cat' => $cat60],
                ['voltage' => '60.8', 'capacity' => '45', 'watt' => '2736', 'warranty' => '4', 'range' => '110-130', 'weight' => '28', 'cat' => $cat60],
                ['voltage' => '73.6', 'capacity' => '30', 'watt' => '2208', 'warranty' => '4', 'range' => '100-120', 'weight' => '25', 'cat' => $cat72],
                ['voltage' => '73.2', 'capacity' => '45', 'watt' => '3312', 'warranty' => '4', 'range' => '140-165', 'weight' => '34', 'cat' => $cat72],
            ];

            foreach ($batteries as $index => $bat) {
                $name = "{$bat['voltage']}V {$bat['capacity']}Ah LFP Battery";
                $slug = \Illuminate\Support\Str::slug($name);

                $product = Product::query()->firstOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id' => $bat['cat'] ? $bat['cat']->id : null,
                        'brand_id' => $brandMain->id,
                        'name' => $name,
                        'short_description' => "High-performance {$bat['voltage']}V {$bat['capacity']}Ah Lithium Iron Phosphate (LFP) battery with a range of {$bat['range']} km.",
                        'description' => "This Magnetic Power {$bat['voltage']}V {$bat['capacity']}Ah LFP battery offers outstanding performance, safety, and longevity. Built for high-efficiency electric vehicles, it delivers continuous {$bat['watt']}W power. It features advanced Smart BMS technology and comes with a {$bat['warranty']} Year warranty.",
                        'is_active' => true,
                        'sort_order' => $index,
                    ]
                );

                $variant = ProductVariant::query()->firstOrCreate(
                    ['product_id' => $product->id, 'slug' => $slug . '-std'],
                    [
                        'sku' => "LFP-{$bat['voltage']}V-{$bat['capacity']}AH",
                        'name' => 'Standard Edition',
                        'voltage' => $bat['voltage'],
                        'capacity' => $bat['capacity'],
                        'chemistry' => 'LFP',
                        'is_default' => true,
                        'is_active' => true,
                        'sort_order' => 0,
                    ]
                );

                $specsToSync = [
                    $specPower->id => ['value' => $bat['watt'], 'sort_order' => 1],
                    $specWarranty->id => ['value' => $bat['warranty'], 'sort_order' => 2],
                    $specRange->id => ['value' => $bat['range'], 'sort_order' => 3],
                    $specCycleLife->id => ['value' => '2000+', 'sort_order' => 4],
                    $specChemistry->id => ['value' => 'LFP (Lithium Iron Phosphate)', 'sort_order' => 5],
                    $specWeight->id => ['value' => $bat['weight'], 'sort_order' => 6],
                ];
                $variant->specifications()->syncWithoutDetaching($specsToSync);

                foreach ($sourceImages as $i => $sourceFile) {
                    if (file_exists($sourceFile)) {
                        $fileName = 'product_' . $product->id . '_' . $i . '_' . time() . '.png';
                        $targetPath = $targetDir . '/' . $fileName;
                        copy($sourceFile, $targetPath);
                        
                        \App\Models\ProductImage::updateOrCreate([
                            'product_id' => $product->id,
                            'sort_order' => $i,
                        ], [
                            'image_path' => 'products/' . $fileName,
                            'alt_text' => $product->name . ' - Image ' . ($i + 1),
                            'is_primary' => $i === 0,
                        ]);
                    }
                }
            }
        }

        // ----------------------------------------------------
        // 6. Inquiries & Contact Messages
        // ----------------------------------------------------
        $variant = class_exists(ProductVariant::class) ? ProductVariant::with('product')->first() : null;

        $inquiries = [
            [
                'phone' => '9876543210',
                'name' => 'Rahul Sharma',
                'email' => 'rahul.sharma@example.com',
                'company_name' => 'Sharma EV Motors',
                'message' => 'Hi, I am interested in bulk purchasing 60V 30Ah LFP batteries for our new scooter lineup. Please share pricing.',
                'source' => 'website',
                'status' => 'new',
            ],
            [
                'phone' => '9123456789',
                'name' => 'Vikas Kumar',
                'email' => 'vikas.k@logistics.in',
                'company_name' => 'Green Logistics',
                'message' => 'Need a quote for 50 units of e-rickshaw 51.2V 100Ah batteries. Delivery in Delhi.',
                'source' => 'whatsapp',
                'status' => 'read',
            ]
        ];

        foreach ($inquiries as $inq) {
            $inq['variant_id'] = $variant?->id;
            $inq['product_name_snapshot'] = $variant?->product?->name ?? '60V 30Ah LFP Scooter Battery';
            $inq['variant_name_snapshot'] = $variant?->name ?? 'Standard Edition';
            
            Inquiry::query()->firstOrCreate(['phone' => $inq['phone']], $inq);
        }

        $contactMessages = [
            [
                'email' => 'priya.verma@example.com',
                'name' => 'Priya Verma',
                'phone' => '9123456780',
                'subject' => 'Dealership enquiry',
                'message' => 'Hello, we are interested in becoming a dealer for Magnetic Power Battery in our region (Maharashtra). Please share the process.',
                'status' => 'new',
            ],
            [
                'email' => 'amit.singh@solartech.com',
                'name' => 'Amit Singh',
                'phone' => '9988776655',
                'subject' => 'Technical Support for Solar Storage',
                'message' => 'I have a query regarding the maximum continuous discharge current for your 48V 100Ah system when used in parallel.',
                'status' => 'closed',
            ]
        ];

        foreach ($contactMessages as $cm) {
            ContactMessage::query()->firstOrCreate(['email' => $cm['email']], $cm);
        }

        // ----------------------------------------------------
        // 7. Company Profile
        // ----------------------------------------------------
        $profile = CompanyProfile::query()->first() ?? new CompanyProfile();
        $profile->fill([
            'company_name' => 'Magnetic Power Battery',
            'tagline' => 'Powering Electric Mobility. Driving a Sustainable Future.',
            'about' => "Magnetic Power Battery is a professional Lithium-ion Battery Manufacturer specializing in advanced LFP (Lithium Iron Phosphate) and NMC (Nickel Manganese Cobalt) battery technologies. \n\nWe provide end-to-end battery solutions for two-wheelers, three-wheelers, solar applications, and custom energy storage projects. With state-of-the-art testing equipment and an automated assembly line, we ensure top-tier quality and safety for all our products.",
            'vision' => 'To become a globally trusted and innovative Lithium Battery Manufacturing Brand, accelerating the world\'s transition to sustainable energy and electric mobility.',
            'mission' => 'To design, manufacture, and deliver safe, high-performance, and technologically advanced battery solutions that exceed customer expectations and reduce carbon footprints.',
        ])->save();

        // ----------------------------------------------------
        // 8. Team Members
        // ----------------------------------------------------
        $team = [
            [
                'name' => 'Md. Alauddin',
                'designation' => 'Production Director',
                'message' => "At Magnetic Power Battery, our focus is on maintaining the highest standards of quality, precision and reliability at every stage of production.\n\nWe are committed to building advanced LFP and NMC battery solutions through efficient manufacturing processes, strict quality control and continuous improvement. Every battery we produce represents our commitment to performance, safety and customer satisfaction.\n\nOur goal is simple — to manufacture reliable energy solutions that power the future of electric mobility with confidence.",
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'name' => 'Mr. Amit Kumar',
                'designation' => 'Managing Director',
                'message' => "At Magnetic Power Battery, our vision is to power the future of mobility with safe, reliable, high-performance and sustainable battery solutions.\n\nWe believe that the future of electric mobility depends not only on advanced technology, but also on quality, safety, reliability and customer trust. Our commitment is to develop and deliver innovative LFP and NMC battery solutions that meet the evolving needs of electric vehicles and energy applications.\n\nOur mission is to contribute towards a cleaner and greener future by making dependable EV battery technology more accessible, efficient and reliable.",
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Anjali Desai',
                'designation' => 'Chief Technology Officer (CTO)',
                'message' => "Innovation is at the core of everything we do. We continuously research and develop next-generation BMS (Battery Management Systems) and cell integration techniques to push the boundaries of what lithium-ion technology can achieve in terms of safety and longevity.",
                'is_active' => true,
                'sort_order' => 2,
            ]
        ];

        foreach ($team as $member) {
            TeamMember::query()->firstOrCreate(['name' => $member['name']], $member);
        }

        // ----------------------------------------------------
        // 9. FAQs
        // ----------------------------------------------------
        $faqs = [
            [
                'question' => 'What types of batteries does Magnetic Power manufacture?',
                'answer' => 'We manufacture LFP (Lithium Iron Phosphate) and NMC (Nickel Manganese Cobalt) lithium-ion batteries for electric vehicles (2-wheelers, 3-wheelers) and energy storage systems.',
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'question' => 'Are your batteries certified for safety?',
                'answer' => 'Yes, all our battery packs undergo rigorous testing and are compliant with relevant national and international safety standards (including AIS 156 Phase 2 standards for India).',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Do you provide a warranty on your EV batteries?',
                'answer' => 'Absolutely. We offer an industry-leading warranty of up to 3 years on our LFP battery range and up to 2 years on our NMC packs, covering manufacturing defects and significant capacity drop.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'What is the average lifespan of your LFP batteries?',
                'answer' => 'Our LFP (Lithium Iron Phosphate) batteries are rated for over 2,000 charge cycles at 80% Depth of Discharge (DoD), which typically translates to 5-7 years of reliable daily use.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'question' => 'Can you manufacture custom battery packs based on specific dimensions and voltage?',
                'answer' => 'Yes, we have a dedicated R&D and engineering team that can design custom battery solutions tailored to your unique voltage, capacity, dimension, and BMS requirements.',
                'is_active' => true,
                'sort_order' => 4,
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::query()->firstOrCreate(['question' => $faq['question']], $faq);
        }

        // ----------------------------------------------------
        // 10. Settings (Contact & Support)
        // ----------------------------------------------------
        $settings = [
            ['key' => 'support_whatsapp', 'value' => '+919876543210', 'group' => 'contact', 'type' => 'string'],
            ['key' => 'support_phone', 'value' => '+91 98765 43210', 'group' => 'contact', 'type' => 'string'],
            ['key' => 'support_email', 'value' => 'support@magneticev.com', 'group' => 'contact', 'type' => 'string'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/magneticev', 'group' => 'social', 'type' => 'string'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/magneticev', 'group' => 'social', 'type' => 'string'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/magneticev', 'group' => 'social', 'type' => 'string'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/magneticev', 'group' => 'social', 'type' => 'string'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/magneticev', 'group' => 'social', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::query()->updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
