@extends('layouts.app')
@section('title', 'Menu - Royal Crest Hotel')

@push('styles')
<style>
.menu-item {
    background: var(--surface, #1a1214);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    transition: all 0.25s ease;
    height: 100%;
}
.menu-item:hover {
    border-color: rgba(201,168,76,0.35);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
}
.menu-item-icon {
    width: 44px; height: 44px;
    background: rgba(201,168,76,0.12);
    border: 1px solid rgba(201,168,76,0.25);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}
.menu-badge {
    font-size: .65rem; font-weight: 700; letter-spacing: .5px;
    padding: .25rem .6rem; border-radius: 6px;
}
.badge-popular { background: rgba(251,191,36,.15); color: #fbbf24; border: 1px solid rgba(251,191,36,.3); }
.badge-new     { background: rgba(74,222,128,.12); color: #4ade80; border: 1px solid rgba(74,222,128,.3); }
.badge-spicy   { background: rgba(248,113,113,.12); color: #f87171; border: 1px solid rgba(248,113,113,.3); }
.badge-vegan   { background: rgba(52,211,153,.12);  color: #34d399; border: 1px solid rgba(52,211,153,.3); }
.category-header {
    border-bottom: 1px solid var(--border);
    padding-bottom: .75rem;
    margin-bottom: 1.5rem;
}
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white">Our Menu</h1>
        <p class="text-white-50">Crafted with passion — from morning to midnight</p>
    </div>
</div>

<section style="padding:50px 0; background:var(--bg-dark,#101111);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">Culinary Delights</span>
            <h2 class="section-title">Explore Our Menu</h2>
            <div class="section-divider"></div>
            <p class="text-muted">Fresh ingredients, authentic flavors, and world-class presentation</p>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-pills justify-content-center mb-5 flex-wrap gap-2" id="menuTabs" role="tablist">
            @foreach([
                ['breakfast',  'bi-sunrise',        'Breakfast'],
                ['lunch',      'bi-sun',             'Lunch'],
                ['dinner',     'bi-moon-stars',      'Dinner'],
                ['desserts',   'bi-cake2',           'Desserts'],
                ['beverages',  'bi-cup-straw',       'Beverages'],
            ] as [$id, $icon, $label])
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $id === 'breakfast' ? 'active' : '' }} d-flex align-items-center gap-2"
                        id="{{ $id }}-tab" data-bs-toggle="pill"
                        data-bs-target="#{{ $id }}" type="button" role="tab">
                    <i class="bi {{ $icon }}"></i> {{ $label }}
                </button>
            </li>
            @endforeach
        </ul>

        <div class="tab-content" id="menuTabContent">

            {{-- ── BREAKFAST ── --}}
            <div class="tab-pane fade show active" id="breakfast" role="tabpanel">
                <div class="category-header d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-sunrise text-gold fs-4"></i>
                    <h5 class="text-white mb-0">Breakfast</h5>
                    <span class="text-muted small ms-2">Served 6:00 AM – 10:30 AM</span>
                </div>
                <div class="row g-3">
                    @foreach([
                        ['Royal Crest Breakfast',    'Scrambled eggs, bacon, pork sausage, toast & hash browns',         '450',  'popular', null],
                        ['Filipino Breakfast',        'Choice of tapsilog, longsilog, or tosilog with garlic rice & coffee','380', 'popular', null],
                        ['Pancake Stack',             'Fluffy buttermilk pancakes with maple syrup and whipped butter',   '320',  null,      null],
                        ['Continental Breakfast',     'Croissant, fresh fruit platter, yogurt, coffee or tea',             '350',  null,      null],
                        ['Eggs Benedict',             'Poached eggs on English muffin with hollandaise sauce & ham',       '420',  'new',     null],
                        ['Avocado Toast',             'Sourdough toast, smashed avocado, cherry tomatoes, poached egg',    '390',  'new',     null],
                        ['Champorado',                'Sweet chocolate rice porridge topped with tuyo or milk',            '220',  null,      null],
                        ['Corned Beef Silog',         'Sautéed corned beef with garlic fried rice and sunny-side up egg',  '350',  null,      null],
                        ['Oatmeal Bowl',              'Creamy oats with banana, honey, granola, and mixed berries',        '280',  'vegan',   null],
                        ['Waffle with Fried Chicken', 'Crispy golden waffle topped with fried chicken and honey butter',  '480',  'popular', null],
                        ['French Toast',              'Thick-cut brioche soaked in egg custard, cinnamon sugar & berries',  '360',  null,      null],
                        ['Shakshuka',                 'Poached eggs in spiced tomato & pepper sauce with crusty bread',     '420',  'new',     null],
                        ['Spinach Omelette',          'Fluffy three-egg omelette with spinach, mushroom & feta cheese',     '380',  null,      null],
                        ['Banana Nutella Crepe',      'Thin French crepe filled with Nutella, sliced banana & almonds',     '320',  'popular', null],
                        ['Garlic Mushroom on Toast',  'Sautéed wild mushrooms with garlic butter on sourdough toast',       '350',  'vegan',   null],
                        ['Smoked Salmon Bagel',       'Toasted bagel with cream cheese, smoked salmon, capers & dill',      '480',  'new',     null],
                        ['Breakfast Burrito',         'Scrambled eggs, cheddar, salsa, sour cream in a warm flour tortilla','420',  null,      null],
                        ['Sikwate & Puto',            'Tablea hot chocolate with steamed rice cakes — a Visayan classic',   '250',  null,      null],
                        ['Quinoa Power Bowl',         'Quinoa, roasted sweet potato, avocado, poached egg & tahini drizzle','450',  'vegan',   null],
                        ['Arroz Caldo',               'Savory Filipino rice congee with chicken, ginger & crispy garlic',   '280',  null,      null],
                        ['Acai Bowl',                 'Frozen acai blended thick, topped with granola, fruits & honey',     '380',  'new',     null],
                        ['Beef Tapa Platter',         'Cured sweet beef slices, garlic rice, pickled papaya & fried egg',   '420',  'popular', null],
                        ['Greek Yogurt Parfait',      'Layers of Greek yogurt, granola, seasonal fruits & honey drizzle',   '280',  'vegan',   null],
                        ['Smashed Potato Hash',       'Crispy smashed potatoes with bacon bits, sour cream & chives',       '350',  null,      null],
                        ['Nutella Stuffed Pancake',   'Thick Japanese-style pancake with Nutella filling & powdered sugar',  '380',  'popular', null],
                        ['Tofu Scramble',             'Silken tofu scramble with turmeric, peppers, onions & toast',        '320',  'vegan',   null],
                        ['Ham & Cheese Croissant',    'Butter croissant filled with Black Forest ham & melted Emmental',    '280',  null,      null],
                        ['Overnight Oats',            'Chia overnight oats with almond milk, mango & chia seeds',           '260',  'vegan',   null],
                        ['Binignit',                  'Warm Visayan sweet soup with bananas, kamote, sago & coconut milk',  '220',  null,      null],
                        ['Turkey Bacon & Eggs',       'Turkey bacon strips with two eggs any style & whole-wheat toast',     '420',  null,      null],
                        ['Mushroom & Truffle Omelette','Three-egg omelette with mixed mushrooms & truffle oil drizzle',     '460',  'new',     null],
                        ['Longganisa Silog',          'Sweet native sausage, garlic fried rice & sunny-side up egg',        '350',  'popular', null],
                        ['Pesto Scrambled Eggs',      'Creamy scrambled eggs with basil pesto on artisan bread',            '380',  null,      null],
                        ['Granola & Fruit Bowl',      'Homemade granola, mixed dried fruits, nuts & warm oat milk',         '250',  'vegan',   null],
                        ['Morning Soup',              'Light chicken broth with misua noodles, egg & spring onion',         '220',  null,      null],
                        ['Smoked Bangus Silog',       'Deboned smoked milkfish, garlic rice, sliced tomatoes & egg',        '380',  'popular', null],
                        ['Blueberry Muffin & Coffee', 'Freshly baked blueberry muffin served with a brewed coffee',         '220',  null,      null],
                        ['Egg White Frittata',        'Baked egg white frittata with zucchini, tomato & low-fat cheese',    '380',  null,      null],
                        ['Kesong Puti Toast',         'Sourdough toast with native white cheese, tomato jam & basil',       '320',  'new',     null],
                    ] as [$name, $desc, $price, $badge, $_])
                    <div class="col-md-6 col-lg-4">
                        <div class="menu-item">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="menu-item-icon">🍳</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h6 class="text-white mb-0 fw-semibold" style="font-size:.92rem;">{{ $name }}</h6>
                                        <span class="text-gold fw-bold text-nowrap" style="font-size:.95rem;">₱{{ $price }}</span>
                                    </div>
                                    <p class="text-muted mb-2" style="font-size:.78rem;line-height:1.5;">{{ $desc }}</p>
                                    @if($badge)
                                    <span class="menu-badge badge-{{ $badge }}">{{ strtoupper($badge) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── LUNCH ── --}}
            <div class="tab-pane fade" id="lunch" role="tabpanel">
                <div class="category-header d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-sun text-gold fs-4"></i>
                    <h5 class="text-white mb-0">Lunch</h5>
                    <span class="text-muted small ms-2">Served 11:30 AM – 2:30 PM</span>
                </div>
                <div class="row g-3">
                    @foreach([
                        ['Sinigang na Baboy',        'Classic Filipino sour tamarind soup with pork ribs and vegetables',  '450',  'popular', null],
                        ['Kare-Kare',                'Oxtail and vegetables in rich peanut sauce with bagoong',             '520',  'popular', null],
                        ['Grilled Chicken Salad',    'Romaine lettuce, grilled chicken breast, croutons, Caesar dressing', '480',  null,      null],
                        ['Club Sandwich',            'Triple-decker with chicken, crispy bacon, lettuce & tomato',          '420',  null,      null],
                        ['Pasta Carbonara',          'Creamy al dente pasta with pancetta, egg yolk & parmesan',            '520',  'popular', null],
                        ['Beef Caldereta',           'Tender beef stewed in rich tomato sauce with olives & bell pepper',   '550',  null,      null],
                        ['Pinakbet',                 'Sautéed mixed vegetables with shrimp paste — a Ilocano classic',      '380',  'vegan',   null],
                        ['Pork Adobo',               'Braised pork belly in soy-vinegar sauce with bay leaf & garlic',      '420',  'popular', null],
                        ['Seafood Pancit Bihon',     'Stir-fried rice noodles with shrimp, squid & mixed vegetables',       '460',  null,      null],
                        ['Margherita Pizza',         'Thin-crust pizza with tomato, fresh mozzarella & basil',              '580',  null,      null],
                        ['Bangus Belly Sisig',       'Crispy milkfish belly sizzling plate with onions and chili',          '490',  'new',     null],
                        ['Vegetable Curry',          'Aromatic Thai-style curry with tofu, coconut milk & seasonal veggies','420',  'vegan',   null],
                        ['Chicken Inasal',           'Visayan-style grilled chicken marinated in vinegar, ginger & annatto','480',  'popular', null],
                        ['Beef Bulalo',              'Slow-cooked beef shank & marrow soup with corn & pechay',             '620',  'popular', null],
                        ['Laing',                    'Dried taro leaves simmered in spicy coconut milk with pork',          '380',  'spicy',   null],
                        ['Chicken Sotanghon Soup',   'Glass noodle soup with tender chicken, carrots & celery',             '380',  null,      null],
                        ['Nilagang Baka',            'Boiled beef soup with potatoes, banana saba & cabbage',               '520',  null,      null],
                        ['Tuna Nicoise Salad',       'Seared tuna, green beans, olives, eggs & capers with vinaigrette',    '520',  null,      null],
                        ['BBQ Pork Ribs (half rack)', 'Slow-smoked pork ribs glazed with honey-chipotle BBQ sauce',         '780',  'popular', null],
                        ['Mushroom & Truffle Pasta', 'Tagliatelle with wild mushrooms, truffle cream & parmesan shavings',  '580',  'new',     null],
                        ['Dinuguan',                 'Pork blood stew with vinegar & chili served with puto',               '420',  'spicy',   null],
                        ['Lomi',                     'Thick egg noodles in rich pork broth with kikiam & squid balls',      '380',  null,      null],
                        ['Greek Salad',              'Tomatoes, cucumber, olives, red onion & feta with olive oil',         '420',  'vegan',   null],
                        ['Pulled Pork Burger',       'Slow-cooked pulled pork, coleslaw, pickles on a brioche bun',         '550',  'popular', null],
                        ['Tom Yum Soup',             'Spicy Thai shrimp soup with lemongrass, galangal & kaffir lime',      '480',  'spicy',   null],
                        ['Chicken Tinola',           'Light ginger broth with chicken, green papaya & malunggay leaves',    '420',  null,      null],
                        ['Prawn & Mango Salad',      'Poached tiger prawns, carabao mango, arugula & citrus dressing',      '560',  'new',     null],
                        ['Tokwat Baboy',             'Crispy tofu & pork ears in spiced vinegar-soy dipping sauce',         '380',  null,      null],
                        ['Bicol Express',            'Pork cooked in coconut milk with shrimp paste & long green chili',    '450',  'spicy',   null],
                        ['Fish & Chips',             'Beer-battered cream dory fillet with tartar sauce & fries',           '520',  null,      null],
                        ['Quesadilla',               'Flour tortilla with chicken, cheddar, salsa & guacamole',             '480',  null,      null],
                        ['Pork Sinigang sa Miso',    'Tangy miso-based sour soup with pork belly & vegetables',             '480',  'new',     null],
                        ['Lechon Manok',             'Whole roasted chicken with native stuffing & atchara',                '680',  'popular', null],
                        ['Vegetable Pancit Canton',  'Stir-fried egg noodles with mixed vegetables in oyster sauce',        '380',  'vegan',   null],
                        ['Baked Mussels',            'New Zealand mussels baked with garlic butter & breadcrumbs',          '480',  'new',     null],
                        ['Lamb Shawarma Wrap',       'Spiced lamb, pickled turnip, garlic sauce in pita bread',             '520',  null,      null],
                        ['Chicken Caesar Wrap',      'Grilled chicken, romaine, parmesan & Caesar dressing in tortilla',    '450',  null,      null],
                        ['Monggo Guisado',           'Sautéed mung beans with pork, shrimp & bitter melon leaves',          '320',  null,      null],
                        ['Calamares',                'Crispy fried squid rings with aioli & lemon wedge',                   '420',  'popular', null],
                        ['Palabok',                  'Rice noodles in shrimp sauce topped with chicharrón & hard-boiled egg','450', 'popular', null],
                    ] as [$name, $desc, $price, $badge, $_])
                    <div class="col-md-6 col-lg-4">
                        <div class="menu-item">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="menu-item-icon">🍱</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h6 class="text-white mb-0 fw-semibold" style="font-size:.92rem;">{{ $name }}</h6>
                                        <span class="text-gold fw-bold text-nowrap" style="font-size:.95rem;">₱{{ $price }}</span>
                                    </div>
                                    <p class="text-muted mb-2" style="font-size:.78rem;line-height:1.5;">{{ $desc }}</p>
                                    @if($badge)
                                    <span class="menu-badge badge-{{ $badge }}">{{ strtoupper($badge) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── DINNER ── --}}
            <div class="tab-pane fade" id="dinner" role="tabpanel">
                <div class="category-header d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-moon-stars text-gold fs-4"></i>
                    <h5 class="text-white mb-0">Dinner</h5>
                    <span class="text-muted small ms-2">Served 6:00 PM – 10:30 PM</span>
                </div>
                <div class="row g-3">
                    @foreach([
                        ['Grilled Ribeye Steak',     '250g USDA beef with mashed potatoes, asparagus & mushroom sauce',   '1,250','popular', null],
                        ['Grilled Salmon Fillet',    'Atlantic salmon, lemon-caper butter sauce, steamed vegetables',      '980',  'popular', null],
                        ['Crispy Pata',              'Deep-fried pork leg, soy-vinegar dipping sauce, pickled papaya',     '850',  'popular', null],
                        ['Chicken Cordon Bleu',      'Stuffed chicken breast with ham & Swiss cheese, cream sauce',        '680',  null,      null],
                        ['Roasted Rack of Lamb',     'Herb-crusted lamb rack with rosemary jus and roasted potatoes',      '1,480','new',     null],
                        ['Tiger Prawn Thermidor',    'Jumbo prawns baked in creamy brandy-mustard sauce with gruyère',     '1,150','new',     null],
                        ['Beef Kare-Kare Premium',   'Slow-braised US beef short rib in peanut sauce, fermented shrimp',   '980',  null,      null],
                        ['Lechon Kawali',            'Crispy pork belly with liver sauce & ensaladang talong',             '720',  'popular', null],
                        ['Whole Roasted Chicken',    'Free-range chicken, herb butter, garlic mashed potato & gravy',      '850',  null,      null],
                        ['Seafood Platter for Two',  'Grilled prawns, squid, mussels & fish fillet with three sauces',    '1,800','popular', null],
                        ['Mushroom Risotto',         'Arborio rice, wild mushroom medley, parmesan, truffle oil',          '620',  'vegan',   null],
                        ['Lamb Chops',               'Pan-seared lamb chops with mint jelly, ratatouille & potato gratin', '1,350','new',     null],
                        ['Sizzling Sisig',           'Chopped pork face & ears sizzling on a cast-iron plate with egg',    '680',  'popular', null],
                        ['Beef Tenderloin Steak',    '200g tenderloin, béarnaise sauce, pomme purée & haricots verts',     '1,450','new',     null],
                        ['Lobster Thermidor',        'Whole lobster baked with creamy brandy sauce & gruyère crust',       '2,800','popular', null],
                        ['Duck Confit',              'Slow-cooked duck leg, cherry reduction & dauphinoise potatoes',      '1,280','new',     null],
                        ['Beef Wellington',          'Pork loin wrapped in mushroom duxelles & puff pastry',               '1,650','popular', null],
                        ['King Prawn Pasta',         'Linguine with king prawns, cherry tomatoes, white wine & chili',     '980',  'popular', null],
                        ['Vegetable Tagine',         'Moroccan spiced vegetable stew with couscous & preserved lemon',     '680',  'vegan',   null],
                        ['Ox Tongue in Cream Sauce', 'Braised ox tongue sliced thin in rich mushroom cream sauce',         '880',  null,      null],
                        ['Grilled Sea Bass',         'Whole sea bass with herbs, lemon & extra virgin olive oil',          '1,080','new',     null],
                        ['Pork Belly Confit',        'Slow-cooked pork belly, apple purée & crackling chips',              '850',  null,      null],
                        ['Beef Osso Buco',           'Braised veal shank in white wine with gremolata & risotto Milanese', '1,350','new',     null],
                        ['Cochinillo',               'Roasted suckling pig with apple sauce & pickled vegetables',         '2,200','popular', null],
                        ['Tiger Prawn Curry',        'Jumbo prawns in aromatic green Thai curry with jasmine rice',        '980',  'spicy',   null],
                        ['Stuffed Bell Peppers',     'Roasted peppers filled with quinoa, feta, olives & sun-dried tomato','680',  'vegan',   null],
                        ['Grilled Tuna Steak',       'Yellow-fin tuna, wasabi aioli, sesame bok choy & ponzu sauce',       '1,050','new',     null],
                        ['Chicken Galantine',        'Deboned chicken stuffed with herbs & served with pan jus',           '780',  null,      null],
                        ['Sautéed Foie Gras',        'Pan-seared duck foie gras, brioche toast & berry compote',           '1,680','popular', null],
                        ['Vegetable Wellington',     'Roasted vegetable medley wrapped in golden puff pastry',             '780',  'vegan',   null],
                        ['Bistek Tagalog',           'Beef sirloin in soy-citrus sauce topped with caramelized onions',    '720',  'popular', null],
                        ['Seafood Risotto',          'Creamy Arborio rice with shrimp, scallops, squid & saffron broth',   '980',  'popular', null],
                        ['Roast Prime Rib',          '300g slow-roasted prime rib with horseradish cream & au jus',        '1,580','new',     null],
                        ['Grilled Octopus',          'Charred octopus tentacle with chimichurri & roasted potatoes',       '980',  'new',     null],
                        ['Pork Medallions',          'Tenderloin medallions, Dijon cream sauce & roasted root vegetables', '880',  null,      null],
                        ['Callos',                   'Spanish-style tripe stew with chorizo, chickpeas & paprika',         '780',  null,      null],
                        ['Chicken Roulade',          'Rolled chicken stuffed with spinach & ricotta, tomato concassé',     '820',  null,      null],
                        ['Surf & Turf',              '150g tenderloin & 3 tiger prawns, compound butter & truffle fries',  '1,980','popular', null],
                        ['Baked Camembert',          'Whole baked camembert with honey, walnuts & crusty bread',           '680',  'new',     null],
                        ['Slow-Roasted Pork Shoulder','8-hour pork shoulder, salsa verde & braised white beans',          '920',  null,      null],
                        ['Pan-Seared Scallops',      'Seared jumbo scallops, pea purée, crispy pancetta & lemon foam',     '1,180','popular', null],
                    ] as [$name, $desc, $price, $badge, $_])
                    <div class="col-md-6 col-lg-4">
                        <div class="menu-item">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="menu-item-icon">🍽️</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h6 class="text-white mb-0 fw-semibold" style="font-size:.92rem;">{{ $name }}</h6>
                                        <span class="text-gold fw-bold text-nowrap" style="font-size:.95rem;">₱{{ $price }}</span>
                                    </div>
                                    <p class="text-muted mb-2" style="font-size:.78rem;line-height:1.5;">{{ $desc }}</p>
                                    @if($badge)
                                    <span class="menu-badge badge-{{ $badge }}">{{ strtoupper($badge) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── DESSERTS ── --}}
            <div class="tab-pane fade" id="desserts" role="tabpanel">
                <div class="category-header d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-cake2 text-gold fs-4"></i>
                    <h5 class="text-white mb-0">Desserts</h5>
                    <span class="text-muted small ms-2">Available all day</span>
                </div>
                <div class="row g-3">
                    @foreach([
                        ['Halo-Halo Royale',         'Premium shaved ice, ube, leche flan, beans, jellies & ice cream',    '320',  'popular', null],
                        ['Crème Brûlée',             'Classic French vanilla custard with caramelized sugar crust',         '380',  'popular', null],
                        ['Chocolate Lava Cake',      'Warm dark chocolate cake with molten center & vanilla ice cream',     '350',  'popular', null],
                        ['Leche Flan',               'Silky smooth Filipino caramel custard, a timeless classic',           '220',  null,      null],
                        ['Brazo de Mercedes',        'Meringue roll filled with rich custard cream',                        '280',  null,      null],
                        ['Tiramisu',                 'Italian mascarpone dessert with espresso-soaked ladyfingers',          '360',  'new',     null],
                        ['Ube Cheesecake',           'No-bake ube cheesecake on graham cracker crust',                      '320',  'new',     null],
                        ['Buko Pandan Salad',        'Young coconut strips with pandan jelly, cream & sweetened milk',      '220',  null,      null],
                        ['Mango Sticky Rice',        'Thai glutinous rice with fresh Philippine mango & coconut cream',      '280',  'popular', null],
                        ['Ice Cream Selection',      'Three scoops: vanilla, chocolate, strawberry, ube, or green tea',     '180',  null,      null],
                        ['Panna Cotta',              'Silky Italian vanilla cream with fresh strawberry coulis',            '320',  'new',     null],
                        ['Churros with Chocolate',  'Crispy fried dough sticks with dark chocolate dipping sauce',         '280',  'popular', null],
                        ['Banana Foster',            'Caramelized banana in rum-butter sauce over vanilla ice cream',       '320',  'new',     null],
                        ['Macapuno Cake',            'Filipino coconut sport jam layered cake with buttercream frosting',   '280',  null,      null],
                        ['Basque Burnt Cheesecake',  'Caramelized top, creamy center, served with seasonal berry compote',  '380',  'popular', null],
                        ['Sago at Gulaman',          'Palm seeds & jelly cubes in sweet brown sugar syrup with ice',        '180',  null,      null],
                        ['Chocolate Fondue for Two', 'Belgian dark chocolate with strawberries, marshmallows & bananas',    '680',  'popular', null],
                        ['Ube Halaya',               'Rich purple yam jam served warm with latik topping',                  '220',  null,      null],
                        ['New York Cheesecake',      'Classic baked cheesecake on a graham crust with berry topping',       '350',  'popular', null],
                        ['Pastillas de Leche',       'Soft milk candies dusted in sugar — a traditional Filipino sweet',    '180',  null,      null],
                        ['Sticky Toffee Pudding',    'Warm date pudding with butterscotch sauce & clotted cream',           '360',  'new',     null],
                        ['Matcha Opera Cake',        'Layered matcha sponge, white chocolate ganache & almond cream',       '380',  'new',     null],
                        ['Taho',                     'Soft silken tofu with arnibal syrup & pearl sago',                    '150',  null,      null],
                        ['Biko',                     'Sticky rice cake with coconut caramel sauce & latik topping',         '220',  null,      null],
                        ['Lemon Tart',               'Crisp pastry shell with tangy lemon curd & toasted meringue peaks',  '320',  null,      null],
                        ['Cassava Cake',             'Dense cassava cake baked with coconut cream & grated cheese',         '220',  'popular', null],
                        ['Pistachio Gelato',         'Artisan Italian pistachio gelato, two scoops',                        '280',  'new',     null],
                        ['Tsokolate Tablea Cake',    'Dark tablea chocolate cake with ganache & sea salt caramel drizzle',  '350',  'popular', null],
                        ['Fruit Salad',              'Seasonal fresh fruits with condensed milk cream & nata de coco',      '220',  null,      null],
                        ['Apple Crumble',            'Warm cinnamon apple filling with oat crumble & vanilla ice cream',    '320',  null,      null],
                        ['Profiteroles',             'Choux pastry puffs filled with cream, drizzled with chocolate',       '320',  null,      null],
                        ['Buko Tart',                'Mini tart shells filled with sweetened young coconut strips',         '180',  null,      null],
                        ['Cheese Plate',             'Selection of three artisan cheeses with crackers, grapes & honey',    '480',  'new',     null],
                        ['Yema Cake',                'Chiffon cake frosted with sweet egg yolk candy coating',              '280',  null,      null],
                        ['Cinnamon Roll',            'Freshly baked giant cinnamon roll with cream cheese icing',           '280',  'popular', null],
                        ['Tres Leches Cake',         'Mexican sponge cake soaked in three milks with whipped cream',        '320',  'new',     null],
                        ['Mochi Ice Cream',          'Japanese rice cake with ice cream filling — 3 pieces per serving',    '280',  'new',     null],
                        ['Pastele de Nata',          'Portuguese egg custard tarts, dusted with cinnamon',                  '220',  null,      null],
                        ['Choco Banana Turon',       'Crispy spring roll with caramelized banana & chocolate inside',       '180',  'popular', null],
                    ] as [$name, $desc, $price, $badge, $_])
                    <div class="col-md-6 col-lg-4">
                        <div class="menu-item">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="menu-item-icon">🍮</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h6 class="text-white mb-0 fw-semibold" style="font-size:.92rem;">{{ $name }}</h6>
                                        <span class="text-gold fw-bold text-nowrap" style="font-size:.95rem;">₱{{ $price }}</span>
                                    </div>
                                    <p class="text-muted mb-2" style="font-size:.78rem;line-height:1.5;">{{ $desc }}</p>
                                    @if($badge)
                                    <span class="menu-badge badge-{{ $badge }}">{{ strtoupper($badge) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── BEVERAGES ── --}}
            <div class="tab-pane fade" id="beverages" role="tabpanel">
                <div class="category-header d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-cup-straw text-gold fs-4"></i>
                    <h5 class="text-white mb-0">Beverages</h5>
                    <span class="text-muted small ms-2">Available 6:00 AM – 12:00 MN</span>
                </div>

                {{-- Sub-category: Coffee --}}
                <h6 class="text-gold mb-3" style="font-size:.8rem;letter-spacing:2px;text-transform:uppercase;">☕ Coffee & Hot Drinks</h6>
                <div class="row g-3 mb-4">
                    @foreach([
                        ['Brewed Coffee',            'Premium Arabica single-origin, hot or iced',                          '150',  null,   null],
                        ['Café Americano',           'Double espresso shots with hot water',                                '160',  null,   null],
                        ['Cappuccino / Latte',       'Espresso with steamed milk foam, choose hot or iced',                 '180',  'popular', null],
                        ['Iced Spanish Latte',       'Espresso, condensed milk, fresh milk over ice',                      '195',  'popular', null],
                        ['Matcha Latte',             'Japanese matcha powder with steamed or cold milk',                    '195',  'new',  null],
                        ['Hot Chocolate',            'Rich Belgian cocoa, steamed milk & marshmallows',                     '170',  null,   null],
                        ['Tsokolate de Batirol',    'Traditional Filipino tablea chocolate whisked in clay pot',           '180',  'popular', null],
                        ['Caramel Macchiato',       'Espresso, vanilla syrup, steamed milk & caramel drizzle',             '195',  'popular', null],
                        ['Dirty Matcha',            'Matcha latte with an espresso shot on top',                           '210',  'new',  null],
                        ['Salted Caramel Latte',    'Espresso, salted caramel syrup & steamed oat milk',                   '200',  'new',  null],
                        ['Chamomile Tea',           'Soothing dried chamomile flowers steeped in hot water',               '120',  'vegan', null],
                        ['Jasmine Green Tea',       'Premium loose-leaf jasmine green tea, hot or iced',                   '130',  'vegan', null],
                        ['Earl Grey',               'Classic black tea with bergamot, served with milk on the side',       '130',  null,   null],
                        ['Iced Brown Sugar Latte',  'Espresso, brown sugar syrup & cold foam over ice',                    '210',  'popular', null],
                        ['Cortado',                 'Double espresso cut with equal parts warm steamed milk',              '170',  null,   null],
                    ] as [$name, $desc, $price, $badge, $_])
                    <div class="col-md-6 col-lg-4">
                        <div class="menu-item">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="menu-item-icon">☕</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h6 class="text-white mb-0 fw-semibold" style="font-size:.92rem;">{{ $name }}</h6>
                                        <span class="text-gold fw-bold text-nowrap" style="font-size:.95rem;">₱{{ $price }}</span>
                                    </div>
                                    <p class="text-muted mb-2" style="font-size:.78rem;line-height:1.5;">{{ $desc }}</p>
                                    @if($badge)
                                    <span class="menu-badge badge-{{ $badge }}">{{ strtoupper($badge) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Sub-category: Juices & Shakes --}}
                <h6 class="text-gold mb-3" style="font-size:.8rem;letter-spacing:2px;text-transform:uppercase;">🥤 Juices, Shakes & Smoothies</h6>
                <div class="row g-3 mb-4">
                    @foreach([
                        ['Fresh Mango Juice',        'Freshly squeezed Philippine carabao mango',                          '180',  'popular', null],
                        ['Calamansi Juice',          'Fresh calamansi juice, sweetened or unsweetened',                    '150',  null,   null],
                        ['Mixed Berry Smoothie',     'Strawberry, blueberry & raspberry blended with yogurt',              '220',  'new',  null],
                        ['Buko Juice',               'Fresh young coconut water served in the shell',                      '160',  null,   null],
                        ['Mango-Pineapple Shake',    'Blended mango and pineapple with milk and ice cream',                '240',  'popular', null],
                        ['Green Detox Juice',        'Spinach, cucumber, green apple, ginger & lemon',                     '210',  'vegan', null],
                        ['Watermelon Juice',        'Freshly blended watermelon with a hint of mint & lime',              '160',  null,   null],
                        ['Pineapple-Ginger Juice',  'Fresh pineapple juice blended with ginger & a pinch of chili',       '180',  'spicy', null],
                        ['Banana Shake',            'Frozen banana blended with milk, honey & vanilla ice cream',         '200',  'popular', null],
                        ['Strawberry Lemonade',     'Fresh strawberry purée with homemade lemonade & mint',               '200',  null,   null],
                        ['Ube Shake',               'Purple yam ice cream blended thick with coconut milk',               '230',  'popular', null],
                        ['Cantaloupe Juice',        'Ripe cantaloupe blended smooth with a splash of lemon',              '170',  null,   null],
                        ['Papaya Milkshake',        'Blended papaya with condensed milk & crushed ice',                   '190',  null,   null],
                        ['Soursop Juice',           'Guyabano (soursop) blended with milk & sweetened to taste',          '190',  'new',  null],
                        ['Lychee & Mint Cooler',    'Lychee juice with fresh mint leaves & sparkling water',              '200',  'new',  null],
                    ] as [$name, $desc, $price, $badge, $_])
                    <div class="col-md-6 col-lg-4">
                        <div class="menu-item">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="menu-item-icon">🥤</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h6 class="text-white mb-0 fw-semibold" style="font-size:.92rem;">{{ $name }}</h6>
                                        <span class="text-gold fw-bold text-nowrap" style="font-size:.95rem;">₱{{ $price }}</span>
                                    </div>
                                    <p class="text-muted mb-2" style="font-size:.78rem;line-height:1.5;">{{ $desc }}</p>
                                    @if($badge)
                                    <span class="menu-badge badge-{{ $badge }}">{{ strtoupper($badge) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Sub-category: Alcoholic --}}
                <h6 class="text-gold mb-3" style="font-size:.8rem;letter-spacing:2px;text-transform:uppercase;">🍷 Wine, Beer & Cocktails</h6>
                <div class="row g-3">
                    @foreach([
                        ['Red / White Wine (glass)', 'Curated selection of Old & New World wines',                          '380',  null,   null],
                        ['Sparkling Wine (glass)',   'Prosecco or Cava by the glass',                                       '420',  'popular', null],
                        ['San Miguel Beer',          'Local beer, regular or light — ice cold',                             '120',  'popular', null],
                        ['Craft Beer (imported)',    'Rotating selection of imported craft beers',                          '280',  null,   null],
                        ['Classic Mojito',           'White rum, fresh mint, lime juice, soda & sugar',                    '320',  'popular', null],
                        ['Margarita',                'Tequila, triple sec, freshly squeezed lime, salted rim',             '350',  null,   null],
                        ['Blue Lagoon',              'Vodka, blue curaçao, lemonade — a tropical favourite',               '330',  'new',  null],
                        ['Non-Alcoholic Cocktail',   'House mocktail: passion fruit, mint, ginger ale & lime',             '180',  'new',  null],
                        ['Piña Colada',             'Rum, coconut cream & pineapple juice blended with crushed ice',      '380',  'popular', null],
                        ['Gin & Tonic',             'Premium gin with tonic water, cucumber, lime & fresh herbs',         '320',  null,   null],
                        ['Whiskey Sour',            'Bourbon whiskey, lemon juice, sugar syrup & egg white foam',         '380',  'popular', null],
                        ['Cosmopolitan',            'Vodka, triple sec, cranberry & freshly squeezed lime juice',         '360',  null,   null],
                        ['Dark & Stormy',           'Dark rum with ginger beer, lime & angostura bitters over ice',       '340',  null,   null],
                        ['Aperol Spritz',           'Aperol, Prosecco & soda water — the Italian aperitif classic',       '380',  'popular', null],
                        ['Long Island Iced Tea',    'Vodka, rum, gin, tequila, triple sec, lemon & cola',                 '420',  'popular', null],
                        ['Lychee Martini',          'Vodka, lychee liqueur & fresh lychee juice, chilled & strained',     '380',  'new',  null],
                        ['Bourbon Old Fashioned',   'Bourbon, sugar cube, angostura bitters & orange twist',              '400',  null,   null],
                        ['Frozen Daiquiri',         'Blended white rum, lime juice & sugar syrup over crushed ice',       '360',  null,   null],
                        ['Tequila Sunrise',         'Tequila, orange juice & grenadine — beautiful sunrise gradient',     '350',  null,   null],
                        ['Hugo Spritz',             'Elderflower syrup, Prosecco, soda, lime & fresh mint leaves',        '360',  'new',  null],
                        ['Paloma',                  'Tequila, fresh grapefruit juice, lime & sparkling soda',             '360',  null,   null],
                        ['Mango Daiquiri',          'White rum, fresh mango purée & lime — frozen or on the rocks',       '370',  'popular', null],
                        ['Negroni',                 'Gin, sweet vermouth & Campari, orange twist',                        '380',  null,   null],
                        ['Strawberry Mojito',       'White rum, fresh strawberries, mint, lime & soda water',             '340',  'popular', null],
                        ['Sour Apple Martini',      'Vodka, sour apple schnapps & fresh apple juice, chilled',            '370',  null,   null],
                        ['Kalamansi Margarita',     'Tequila, triple sec & fresh kalamansi juice — a Filipino twist',     '360',  'new',  null],
                        ['Virgin Mojito',           'Fresh mint, lime, sugar syrup & sparkling water — alcohol-free',     '180',  null,   null],
                    ] as [$name, $desc, $price, $badge, $_])
                    <div class="col-md-6 col-lg-4">
                        <div class="menu-item">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="menu-item-icon">🍷</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h6 class="text-white mb-0 fw-semibold" style="font-size:.92rem;">{{ $name }}</h6>
                                        <span class="text-gold fw-bold text-nowrap" style="font-size:.95rem;">₱{{ $price }}</span>
                                    </div>
                                    <p class="text-muted mb-2" style="font-size:.78rem;line-height:1.5;">{{ $desc }}</p>
                                    @if($badge)
                                    <span class="menu-badge badge-{{ $badge }}">{{ strtoupper($badge) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>{{-- end tab-content --}}

        {{-- Legend --}}
        <div class="d-flex flex-wrap justify-content-center gap-3 mt-5 pt-3" style="border-top:1px solid var(--border);">
            <span class="menu-badge badge-popular">POPULAR</span><span class="text-muted small">Best sellers</span>
            <span class="menu-badge badge-new ms-3">NEW</span><span class="text-muted small">New additions</span>
            <span class="menu-badge badge-vegan ms-3">VEGAN</span><span class="text-muted small">Plant-based</span>
            <span class="menu-badge badge-spicy ms-3">SPICY</span><span class="text-muted small">Contains chili</span>
        </div>

        <p class="text-muted small text-center mt-4">
            All prices are in Philippine Peso (₱) and are VAT-inclusive. Prices subject to change without prior notice.<br>
            Please inform your server of any food allergies or dietary restrictions.
        </p>

    </div>
</section>
@endsection
