<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;
use App\Models\Testimonial;
use App\Models\Facility;

class PopulateTranslations extends Command
{
    protected $signature = 'app:populate-translations';
    protected $description = 'Populate multi-language translations for rooms, testimonials, and facilities';

    public function handle()
    {
        $this->populateRooms();
        $this->populateTestimonials();
        $this->populateFacilities();
        $this->info('✅ All translations populated successfully!');
    }

    private function populateRooms()
    {
        $this->info('Populating room translations...');

        $translations = [
            // id => ['name' => [...], 'description' => [...]]
            1 => [
                'name' => [
                    'fil' => 'Garden Deluxe',
                    'ja'  => 'ガーデンデラックス',
                    'ko'  => '가든 디럭스',
                    'zh'  => '花园豪华房',
                    'es'  => 'Deluxe Jardín',
                ],
                'description' => [
                    'fil' => 'Ang Garden Deluxe ay nag-aalok ng mainit at masayang pahingahan na may maingat na piniling muwebles. I-enjoy ang modernong kaginhawaan kasama ang mabilis na WiFi, flat-screen TV, at maluho na pribadong banyo.',
                    'ja'  => 'ガーデンデラックスは、精選されたインテリアで温かく快適なリトリートを提供します。高速Wi-Fi、薄型テレビ、豪華なプライベートバスルームなど、現代的な快適設備をお楽しみください。',
                    'ko'  => '가든 디럭스는 세심하게 큐레이션된 가구로 따뜻하고 아늑한 휴식 공간을 제공합니다. 초고속 WiFi, 평면 TV, 럭셔리 개인 욕실 등 현대적인 편의 시설을 즐기세요.',
                    'zh'  => '花园豪华房提供温馨舒适的休憩空间，配备精心挑选的家具。享受现代便利设施，包括高速WiFi、平板电视和豪华私人浴室。',
                    'es'  => 'El Deluxe Jardín ofrece un cálido y acogedor retiro con mobiliario cuidadosamente seleccionado. Disfrute de comodidades modernas como WiFi de alta velocidad, TV de pantalla plana y un lujoso baño privado.',
                ],
            ],
            2 => [
                'name' => [
                    'fil' => 'Pool Deluxe',
                    'ja'  => 'プールデラックス',
                    'ko'  => '풀 디럭스',
                    'zh'  => '泳池豪华房',
                    'es'  => 'Deluxe Piscina',
                ],
                'description' => [
                    'fil' => 'Ang Pool Deluxe ay nag-aalok ng mainit at masayang pahingahan na may maingat na piniling muwebles. I-enjoy ang modernong kaginhawaan kasama ang mabilis na WiFi, flat-screen TV, at maluho na pribadong banyo.',
                    'ja'  => 'プールデラックスは、精選されたインテリアで温かく快適なリトリートを提供します。高速Wi-Fi、薄型テレビ、豪華なプライベートバスルームなど、現代的な快適設備をお楽しみください。',
                    'ko'  => '풀 디럭스는 세심하게 큐레이션된 가구로 따뜻하고 아늑한 휴식 공간을 제공합니다. 초고속 WiFi, 평면 TV, 럭셔리 개인 욕실 등 현대적인 편의 시설을 즐기세요.',
                    'zh'  => '泳池豪华房提供温馨舒适的休憩空间，配备精心挑选的家具。享受现代便利设施，包括高速WiFi、平板电视和豪华私人浴室。',
                    'es'  => 'El Deluxe Piscina ofrece un cálido y acogedor retiro con mobiliario cuidadosamente seleccionado. Disfrute de comodidades modernas como WiFi de alta velocidad, TV de pantalla plana y un lujoso baño privado.',
                ],
            ],
            3 => [
                'name' => [
                    'fil' => 'City Deluxe',
                    'ja'  => 'シティデラックス',
                    'ko'  => '시티 디럭스',
                    'zh'  => '城景豪华房',
                    'es'  => 'Deluxe Ciudad',
                ],
                'description' => [
                    'fil' => 'Ang City Deluxe ay nag-aalok ng mainit at masayang pahingahan na may maingat na piniling muwebles. I-enjoy ang modernong kaginhawaan kasama ang mabilis na WiFi, flat-screen TV, at maluho na pribadong banyo.',
                    'ja'  => 'シティデラックスは、精選されたインテリアで温かく快適なリトリートを提供します。高速Wi-Fi、薄型テレビ、豪華なプライベートバスルームなど、現代的な快適設備をお楽しみください。',
                    'ko'  => '시티 디럭스는 세심하게 큐레이션된 가구로 따뜻하고 아늑한 휴식 공간을 제공합니다. 초고속 WiFi, 평면 TV, 럭셔리 개인 욕실 등 현대적인 편의 시설을 즐기세요.',
                    'zh'  => '城景豪华房提供温馨舒适的休憩空间，配备精心挑选的家具。享受现代便利设施，包括高速WiFi、平板电视和豪华私人浴室。',
                    'es'  => 'El Deluxe Ciudad ofrece un cálido y acogedor retiro con mobiliario cuidadosamente seleccionado. Disfrute de comodidades modernas con WiFi de alta velocidad, TV de pantalla plana y un lujoso baño privado.',
                ],
            ],
            4 => [
                'name' => [
                    'fil' => 'Twin Deluxe',
                    'ja'  => 'ツインデラックス',
                    'ko'  => '트윈 디럭스',
                    'zh'  => '双床豪华房',
                    'es'  => 'Deluxe Twin',
                ],
                'description' => [
                    'fil' => 'Ang Twin Deluxe ay nag-aalok ng mainit at masayang pahingahan na may maingat na piniling muwebles. I-enjoy ang modernong kaginhawaan kasama ang mabilis na WiFi, flat-screen TV, at maluho na pribadong banyo.',
                    'ja'  => 'ツインデラックスは、精選されたインテリアで温かく快適なリトリートを提供します。高速Wi-Fi、薄型テレビ、豪華なプライベートバスルームなど、現代的な快適設備をお楽しみください。',
                    'ko'  => '트윈 디럭스는 세심하게 큐레이션된 가구로 따뜻하고 아늑한 휴식 공간을 제공합니다. 초고속 WiFi, 평면 TV, 럭셔리 개인 욕실 등 현대적인 편의 시설을 즐기세요.',
                    'zh'  => '双床豪华房提供温馨舒适的休憩空间，配备精心挑选的家具。享受现代便利设施，包括高速WiFi、平板电视和豪华私人浴室。',
                    'es'  => 'El Deluxe Twin ofrece un cálido y acogedor retiro con mobiliario cuidadosamente seleccionado. WiFi de alta velocidad, TV de pantalla plana y lujoso baño privado.',
                ],
            ],
            5 => [
                'name' => [
                    'fil' => 'Corner Deluxe',
                    'ja'  => 'コーナーデラックス',
                    'ko'  => '코너 디럭스',
                    'zh'  => '转角豪华房',
                    'es'  => 'Deluxe Esquina',
                ],
                'description' => [
                    'fil' => 'Ang Corner Deluxe ay nag-aalok ng mainit at masayang pahingahan na may maingat na piniling muwebles. I-enjoy ang modernong kaginhawaan kasama ang mabilis na WiFi, flat-screen TV, at maluho na pribadong banyo.',
                    'ja'  => 'コーナーデラックスは、精選されたインテリアで温かく快適なリトリートを提供します。高速Wi-Fi、薄型テレビ、豪華なプライベートバスルームなど、現代的な快適設備をお楽しみください。',
                    'ko'  => '코너 디럭스는 세심하게 큐레이션된 가구로 따뜻하고 아늑한 휴식 공간을 제공합니다. 초고속 WiFi, 평면 TV, 럭셔리 개인 욕실 등 현대적인 편의 시설을 즐기세요.',
                    'zh'  => '转角豪华房提供温馨舒适的休憩空间，配备精心挑选的家具。享受现代便利设施，包括高速WiFi、平板电视和豪华私人浴室。',
                    'es'  => 'El Deluxe Esquina ofrece un cálido y acogedor retiro con mobiliario cuidadosamente seleccionado. WiFi de alta velocidad, TV de pantalla plana y lujoso baño privado.',
                ],
            ],
            6 => [
                'name' => [
                    'fil' => 'Superior Standard',
                    'ja'  => 'スーペリアスタンダード',
                    'ko'  => '수페리어 스탠다드',
                    'zh'  => '高级标准房',
                    'es'  => 'Superior Estándar',
                ],
                'description' => [
                    'fil' => 'Maranasan ang mas mataas na antas ng kaginhawaan sa aming Superior Standard. Nagtatampok ng pinong dekorasyon, maluwag na layout, at premium na bedding para sa mapayapang pahinga.',
                    'ja'  => 'スーペリアスタンダードで上質な快適さをご体験ください。洗練されたデコレーション、広々としたレイアウト、ゆったりと眠れるプレミアム寝具を備えています。',
                    'ko'  => '수페리어 스탠다드에서 한층 높은 편안함을 경험하세요. 세련된 인테리어, 넓은 공간, 숙면을 위한 프리미엄 침구를 갖추고 있습니다.',
                    'zh'  => '在高级标准房中体验卓越舒适。配备精致装潢、宽敞布局和确保优质睡眠的高档床品。',
                    'es'  => 'Experimente la comodidad elevada en nuestro Superior Estándar. Cuenta con decoración refinada, amplia distribución y ropa de cama premium para una noche de descanso.',
                ],
            ],
            7 => [
                'name' => [
                    'fil' => 'Superior Pool View',
                    'ja'  => 'スーペリアプールビュー',
                    'ko'  => '수페리어 풀뷰',
                    'zh'  => '高级泳池景观房',
                    'es'  => 'Superior Vista Piscina',
                ],
                'description' => [
                    'fil' => 'Maranasan ang mas mataas na antas ng kaginhawaan sa aming Superior Pool View. Nagtatampok ng pinong dekorasyon, maluwag na layout, at premium na bedding para sa mapayapang pahinga.',
                    'ja'  => 'スーペリアプールビューで上質な快適さをご体験ください。洗練されたデコレーション、広々としたレイアウト、ゆったりと眠れるプレミアム寝具を備えています。',
                    'ko'  => '수페리어 풀뷰에서 한층 높은 편안함을 경험하세요. 세련된 인테리어, 넓은 공간, 숙면을 위한 프리미엄 침구를 갖추고 있습니다.',
                    'zh'  => '在高级泳池景观房中体验卓越舒适。配备精致装潢、宽敞布局和确保优质睡眠的高档床品。',
                    'es'  => 'Experimente la comodidad elevada en nuestro Superior Vista Piscina. Decoración refinada, amplia distribución y ropa de cama premium.',
                ],
            ],
            8 => [
                'name' => [
                    'fil' => 'Superior Twin',
                    'ja'  => 'スーペリアツイン',
                    'ko'  => '수페리어 트윈',
                    'zh'  => '高级双床房',
                    'es'  => 'Superior Twin',
                ],
                'description' => [
                    'fil' => 'Maranasan ang mas mataas na antas ng kaginhawaan sa aming Superior Twin. Nagtatampok ng pinong dekorasyon, maluwag na layout, at premium na bedding para sa mapayapang pahinga.',
                    'ja'  => 'スーペリアツインで上質な快適さをご体験ください。洗練されたデコレーション、広々としたレイアウト、ゆったりと眠れるプレミアム寝具を備えています。',
                    'ko'  => '수페리어 트윈에서 한층 높은 편안함을 경험하세요. 세련된 인테리어, 넓은 공간, 숙면을 위한 프리미엄 침구를 갖추고 있습니다.',
                    'zh'  => '在高级双床房中体验卓越舒适。配备精致装潢、宽敞布局和确保优质睡眠的高档床品。',
                    'es'  => 'Experimente la comodidad elevada en nuestro Superior Twin. Decoración refinada, amplia distribución y ropa de cama premium.',
                ],
            ],
            9 => [
                'name' => [
                    'fil' => 'Superior Deluxe',
                    'ja'  => 'スーペリアデラックス',
                    'ko'  => '수페리어 디럭스',
                    'zh'  => '高级豪华房',
                    'es'  => 'Superior Deluxe',
                ],
                'description' => [
                    'fil' => 'Maranasan ang mas mataas na antas ng kaginhawaan sa aming Superior Deluxe. Nagtatampok ng pinong dekorasyon, maluwag na layout, at premium na bedding para sa mapayapang pahinga.',
                    'ja'  => 'スーペリアデラックスで上質な快適さをご体験ください。洗練されたデコレーション、広々としたレイアウト、ゆったりと眠れるプレミアム寝具を備えています。',
                    'ko'  => '수페리어 디럭스에서 한층 높은 편안함을 경험하세요. 세련된 인테리어, 넓은 공간, 숙면을 위한 프리미엄 침구를 갖추고 있습니다.',
                    'zh'  => '在高级豪华房中体验卓越舒适。配备精致装潢、宽敞布局和确保优质睡眠的高档床品。',
                    'es'  => 'Experimente la comodidad elevada en nuestro Superior Deluxe. Decoración refinada, amplia distribución y ropa de cama premium.',
                ],
            ],
            10 => [
                'name' => [
                    'fil' => 'Superior Corner',
                    'ja'  => 'スーペリアコーナー',
                    'ko'  => '수페리어 코너',
                    'zh'  => '高级转角房',
                    'es'  => 'Superior Esquina',
                ],
                'description' => [
                    'fil' => 'Maranasan ang mas mataas na antas ng kaginhawaan sa aming Superior Corner. Nagtatampok ng pinong dekorasyon, maluwag na layout, at premium na bedding para sa mapayapang pahinga.',
                    'ja'  => 'スーペリアコーナーで上質な快適さをご体験ください。洗練されたデコレーション、広々としたレイアウト、ゆったりと眠れるプレミアム寝具を備えています。',
                    'ko'  => '수페리어 코너에서 한층 높은 편안함을 경험하세요. 세련된 인테리어, 넓은 공간, 숙면을 위한 프리미엄 침구를 갖추고 있습니다.',
                    'zh'  => '在高级转角房中体验卓越舒适。配备精致装潢、宽敞布局和确保优质睡眠的高档床品。',
                    'es'  => 'Experimente la comodidad elevada en nuestro Superior Esquina. Decoración refinada, amplia distribución y ropa de cama premium.',
                ],
            ],
            11 => [
                'name' => [
                    'fil' => 'Premier Classic',
                    'ja'  => 'プレミアクラシック',
                    'ko'  => '프리미어 클래식',
                    'zh'  => '豪华经典房',
                    'es'  => 'Premier Clásico',
                ],
                'description' => [
                    'fil' => 'Ang Premier Classic ay nagtatakda ng pinipigilan na luho. I-enjoy ang maluwag na espasyo, premium na amenities, at kahanga-hangang tanawin na nagtatakda ng tono para sa isang hindi malilimutang pananatili.',
                    'ja'  => 'プレミアクラシックは抑制された贅沢を体現します。広々とした生活空間、プレミアムアメニティ、そして忘れられない滞在を演出する素晴らしい眺望をお楽しみください。',
                    'ko'  => '프리미어 클래식은 절제된 럭셔리를 정의합니다. 넓은 생활 공간, 프리미엄 편의 시설, 그리고 잊을 수 없는 체류를 위한 멋진 전망을 즐기세요.',
                    'zh'  => '豪华经典房诠释了低调奢华。尽享宽敞的生活空间、高端设施以及令人叹为观止的美景，为难忘的住宿奠定基调。',
                    'es'  => 'El Premier Clásico define el lujo sobrio. Disfrute de amplios espacios, amenidades premium y vistas impresionantes para una estancia inolvidable.',
                ],
            ],
            12 => [
                'name' => [
                    'fil' => 'Premier Pool View',
                    'ja'  => 'プレミアプールビュー',
                    'ko'  => '프리미어 풀뷰',
                    'zh'  => '豪华泳池景观房',
                    'es'  => 'Premier Vista Piscina',
                ],
                'description' => [
                    'fil' => 'Ang Premier Pool View ay nagtatakda ng pinipigilan na luho. I-enjoy ang maluwag na espasyo, premium na amenities, at kahanga-hangang tanawin ng pool na nagtatakda ng tono para sa isang hindi malilimutang pananatili.',
                    'ja'  => 'プレミアプールビューは抑制された贅沢を体現します。広々とした生活空間、プレミアムアメニティ、そして素晴らしいプールビューをお楽しみください。',
                    'ko'  => '프리미어 풀뷰는 절제된 럭셔리를 정의합니다. 넓은 생활 공간, 프리미엄 편의 시설, 그리고 멋진 풀뷰를 즐기세요.',
                    'zh'  => '豪华泳池景观房诠释了低调奢华。尽享宽敞的生活空间、高端设施以及令人叹为观止的泳池美景。',
                    'es'  => 'El Premier Vista Piscina define el lujo sobrio. Amplios espacios, amenidades premium y vistas impresionantes a la piscina.',
                ],
            ],
            13 => [
                'name' => [
                    'fil' => 'Premier Garden',
                    'ja'  => 'プレミアガーデン',
                    'ko'  => '프리미어 가든',
                    'zh'  => '豪华花园房',
                    'es'  => 'Premier Jardín',
                ],
                'description' => [
                    'fil' => 'Ang Premier Garden ay nagtatakda ng pinipigilan na luho. I-enjoy ang maluwag na espasyo, premium na amenities, at kagandahan ng hardin na nagtatakda ng tono para sa isang hindi malilimutang pananatili.',
                    'ja'  => 'プレミアガーデンは抑制された贅沢を体現します。広々とした生活空間、プレミアムアメニティ、そして美しいガーデンビューをお楽しみください。',
                    'ko'  => '프리미어 가든은 절제된 럭셔리를 정의합니다. 넓은 생활 공간, 프리미엄 편의 시설, 그리고 아름다운 정원 전망을 즐기세요.',
                    'zh'  => '豪华花园房诠释了低调奢华。尽享宽敞的生活空间、高端设施以及优美的花园景色。',
                    'es'  => 'El Premier Jardín define el lujo sobrio. Amplios espacios, amenidades premium y hermosas vistas al jardín.',
                ],
            ],
            14 => [
                'name' => [
                    'fil' => 'Premier Twin',
                    'ja'  => 'プレミアツイン',
                    'ko'  => '프리미어 트윈',
                    'zh'  => '豪华双床房',
                    'es'  => 'Premier Twin',
                ],
                'description' => [
                    'fil' => 'Ang Premier Twin ay nagtatakda ng pinipigilan na luho. I-enjoy ang maluwag na espasyo, premium na amenities, at kahanga-hangang tanawin na nagtatakda ng tono para sa isang hindi malilimutang pananatili.',
                    'ja'  => 'プレミアツインは抑制された贅沢を体現します。広々とした生活空間、プレミアムアメニティ、そして素晴らしい眺望をお楽しみください。',
                    'ko'  => '프리미어 트윈은 절제된 럭셔리를 정의합니다. 넓은 생활 공간, 프리미엄 편의 시설, 그리고 멋진 전망을 즐기세요.',
                    'zh'  => '豪华双床房诠释了低调奢华。尽享宽敞的生活空间、高端设施以及令人叹为观止的美景。',
                    'es'  => 'El Premier Twin define el lujo sobrio. Amplios espacios, amenidades premium y vistas impresionantes.',
                ],
            ],
            15 => [
                'name' => [
                    'fil' => 'Executive Classic',
                    'ja'  => 'エグゼクティブクラシック',
                    'ko'  => '이그제큐티브 클래식',
                    'zh'  => '行政经典房',
                    'es'  => 'Ejecutivo Clásico',
                ],
                'description' => [
                    'fil' => 'Ang aming Executive Classic ay perpekto para sa mapagpili na business traveler o leisure guest na naghahanap ng karagdagang espasyo. I-enjoy ang hiwalay na sala, mini bar, at eksklusibong butler service.',
                    'ja'  => 'エグゼクティブクラシックは、より広い空間をお求めの目の肥えたビジネス旅行者やレジャー客に最適です。独立したリビングエリア、ミニバー、専属バトラーサービスをお楽しみください。',
                    'ko'  => '이그제큐티브 클래식은 넓은 공간을 원하는 까다로운 비즈니스 여행객이나 레저 고객에게 완벽합니다. 별도의 거실, 미니바, 전담 버틀러 서비스를 즐기세요.',
                    'zh'  => '行政经典房非常适合追求额外空间的商务或休闲旅行者。享受独立起居区、迷你吧和专属管家服务。',
                    'es'  => 'Nuestro Ejecutivo Clásico es perfecto para el viajero de negocios o leisure que busca espacio extra. Sala de estar independiente, mini bar y servicio de mayordomo exclusivo.',
                ],
            ],
            16 => [
                'name' => [
                    'fil' => 'Executive Pool View',
                    'ja'  => 'エグゼクティブプールビュー',
                    'ko'  => '이그제큐티브 풀뷰',
                    'zh'  => '行政泳池景观房',
                    'es'  => 'Ejecutivo Vista Piscina',
                ],
                'description' => [
                    'fil' => 'Ang aming Executive Pool View ay perpekto para sa mapagpili na business traveler o leisure guest. I-enjoy ang hiwalay na sala, mini bar, at eksklusibong butler service na may magandang tanawin ng pool.',
                    'ja'  => 'エグゼクティブプールビューは、目の肥えたビジネス旅行者やレジャー客に最適です。独立したリビングエリア、ミニバー、専属バトラーサービス、そして美しいプールビューをお楽しみください。',
                    'ko'  => '이그제큐티브 풀뷰는 까다로운 비즈니스 여행객이나 레저 고객에게 완벽합니다. 별도의 거실, 미니바, 전담 버틀러 서비스와 아름다운 풀뷰를 즐기세요.',
                    'zh'  => '行政泳池景观房非常适合商务或休闲旅行者。享受独立起居区、迷你吧和专属管家服务，同时欣赏泳池美景。',
                    'es'  => 'Nuestro Ejecutivo Vista Piscina es perfecto para viajeros que buscan espacio extra. Sala independiente, mini bar, servicio de mayordomo y vistas a la piscina.',
                ],
            ],
            17 => [
                'name' => [
                    'fil' => 'Executive Twin',
                    'ja'  => 'エグゼクティブツイン',
                    'ko'  => '이그제큐티브 트윈',
                    'zh'  => '行政双床房',
                    'es'  => 'Ejecutivo Twin',
                ],
                'description' => [
                    'fil' => 'Ang aming Executive Twin ay perpekto para sa mapagpili na business traveler o leisure guest. I-enjoy ang hiwalay na sala, mini bar, at eksklusibong butler service.',
                    'ja'  => 'エグゼクティブツインは、目の肥えたビジネス旅行者やレジャー客に最適です。独立したリビングエリア、ミニバー、専属バトラーサービスをお楽しみください。',
                    'ko'  => '이그제큐티브 트윈은 까다로운 비즈니스 여행객이나 레저 고객에게 완벽합니다. 별도의 거실, 미니바, 전담 버틀러 서비스를 즐기세요.',
                    'zh'  => '行政双床房非常适合商务或休闲旅行者。享受独立起居区、迷你吧和专属管家服务。',
                    'es'  => 'Nuestro Ejecutivo Twin es perfecto para viajeros que buscan espacio extra. Sala independiente, mini bar y servicio de mayordomo exclusivo.',
                ],
            ],
            18 => [
                'name' => [
                    'fil' => 'Family Garden Suite',
                    'ja'  => 'ファミリーガーデンスイート',
                    'ko'  => '패밀리 가든 스위트',
                    'zh'  => '家庭花园套房',
                    'es'  => 'Suite Familiar Jardín',
                ],
                'description' => [
                    'fil' => 'Idinisenyo para sa mga pamilya, ang Family Garden Suite ay nagbibigay ng sapat na espasyo, maraming lugar ng tulugan, at lahat ng kaginhawaan ng bahay sa isang maluho na kapaligiran ng hotel.',
                    'ja'  => 'ご家族のために設計されたファミリーガーデンスイートは、豪華なホテル環境で十分なスペース、複数の寝室、そして家庭のすべての快適さを提供します。',
                    'ko'  => '가족을 위해 설계된 패밀리 가든 스위트는 호화로운 호텔 환경에서 충분한 공간, 여러 개의 침실 공간, 가정의 모든 편의 시설을 제공합니다.',
                    'zh'  => '专为家庭设计的家庭花园套房在奢华酒店环境中提供充裕的空间、多个睡眠区域以及家一般的舒适体验。',
                    'es'  => 'Diseñada pensando en las familias, la Suite Familiar Jardín ofrece amplio espacio, múltiples áreas de descanso y todas las comodidades del hogar en un entorno hotelero de lujo.',
                ],
            ],
            19 => [
                'name' => [
                    'fil' => 'Family Pool Suite',
                    'ja'  => 'ファミリープールスイート',
                    'ko'  => '패밀리 풀 스위트',
                    'zh'  => '家庭泳池套房',
                    'es'  => 'Suite Familiar Piscina',
                ],
                'description' => [
                    'fil' => 'Idinisenyo para sa mga pamilya, ang Family Pool Suite ay nagbibigay ng sapat na espasyo, maraming lugar ng tulugan, at lahat ng kaginhawaan ng bahay sa isang maluho na kapaligiran ng hotel.',
                    'ja'  => 'ご家族のために設計されたファミリープールスイートは、豪華なホテル環境で十分なスペース、複数の寝室エリア、そして家庭のすべての快適さを提供します。',
                    'ko'  => '가족을 위해 설계된 패밀리 풀 스위트는 호화로운 호텔 환경에서 충분한 공간, 여러 개의 침실 공간, 가정의 모든 편의 시설을 제공합니다.',
                    'zh'  => '专为家庭设计的家庭泳池套房在奢华酒店环境中提供充裕的空间、多个睡眠区域以及家一般的舒适体验。',
                    'es'  => 'Diseñada pensando en las familias, la Suite Familiar Piscina ofrece amplio espacio, múltiples áreas de descanso y todas las comodidades del hogar en un entorno de lujo.',
                ],
            ],
            20 => [
                'name' => [
                    'fil' => 'Presidential Suite',
                    'ja'  => 'プレジデンシャルスイート',
                    'ko'  => '프레지덴셜 스위트',
                    'zh'  => '总统套房',
                    'es'  => 'Suite Presidencial',
                ],
                'description' => [
                    'fil' => 'Ang pinakamataas na antas ng luho ng Royal Crest Hotel. Ang Presidential Suite ay nag-aalok ng walang kapantay na karanasan na may panoramic na tanawin, malawak na sala, at world-class na personalisadong serbisyo.',
                    'ja'  => 'ロイヤルクレストホテルが誇る最高峰の贅沢。プレジデンシャルスイートは、パノラマの眺望、壮大なリビングスペース、そして世界クラスのパーソナライズされたサービスによる比類なき体験を提供します。',
                    'ko'  => '로열 크레스트 호텔의 최고 럭셔리입니다. 프레지덴셜 스위트는 파노라마 전망, 웅장한 거실 공간, 세계 최고 수준의 개인화된 서비스로 비할 데 없는 경험을 제공합니다.',
                    'zh'  => '这是皇家之冠酒店奢华的巅峰之作。总统套房提供无与伦比的体验，拥有全景视野、宏伟的起居空间和世界级的个性化服务。',
                    'es'  => 'La cúspide del lujo en el Hotel Royal Crest. La Suite Presidencial ofrece una experiencia sin igual con vistas panorámicas, amplios espacios y servicio personalizado de clase mundial.',
                ],
            ],
        ];

        foreach ($translations as $id => $data) {
            Room::where('id', $id)->update([
                'name_translations'        => json_encode($data['name']),
                'description_translations' => json_encode($data['description']),
            ]);
        }

        $this->info('  ✓ Rooms done (' . count($translations) . ' rooms)');
    }

    private function populateTestimonials()
    {
        $this->info('Populating testimonial translations...');

        $translations = [
            1 => [
                'content' => [
                    'fil' => '"Kahanga-hangang hotel! Ang Presidential Suite ay higit pa sa aming mga inaasahan. Ang mga kawani ay napaka-attentive at ang pagkain sa restaurant ay world-class. Babalik kami!"',
                    'ja'  => '"素晴らしいホテルです！プレジデンシャルスイートは期待をはるかに超えました。スタッフは非常に気配りがあり、レストランの食事は世界クラスです。また来ます！"',
                    'ko'  => '"정말 멋진 호텔입니다! 프레지덴셜 스위트는 우리의 모든 기대를 뛰어넘었습니다. 직원들은 매우 친절하고 레스토랑 음식은 세계적 수준입니다. 꼭 다시 올 것입니다!"',
                    'zh'  => '"令人叹为观止的酒店！总统套房超越了我们所有的期望。工作人员极为周到，餐厅的食物达到世界级水准。我们一定会再来！"',
                    'es'  => '"¡Hotel absolutamente impresionante! La Suite Presidencial superó todas nuestras expectativas. El personal fue increíblemente atento y la comida del restaurante fue de clase mundial. ¡Definitivamente volveremos!"',
                ],
                'guest_name' => [
                    'fil' => 'Maria Santos', 'ja' => 'マリア・サントス', 'ko' => '마리아 산토스', 'zh' => '玛丽亚·桑托斯', 'es' => 'Maria Santos',
                ],
                'guest_location' => [
                    'fil' => 'Maynila, Pilipinas', 'ja' => 'マニラ、フィリピン', 'ko' => '마닐라, 필리핀', 'zh' => '马尼拉，菲律宾', 'es' => 'Manila, Filipinas',
                ],
            ],
            2 => [
                'content' => [
                    'fil' => '"Ang Royal Crest Hotel ay isang nakatagong kayamanan sa Pangasinan. Ang lugar ng pool ay maganda, malinis ang mga kwarto, at walang kapintasan ang serbisyo. Perpekto para sa romantic na bakasyon."',
                    'ja'  => '"ロイヤルクレストホテルはパンガシナンの隠れた宝石です。プールエリアは美しく、お部屋は清潔で、サービスは申し分ありません。ロマンティックな旅行に最適です。"',
                    'ko'  => '"로열 크레스트 호텔은 팡가시난의 숨겨진 보석입니다. 수영장 지역이 아름답고, 객실은 깨끗하며, 서비스는 완벽합니다. 로맨틱한 여행에 안성맞춤입니다."',
                    'zh'  => '"皇家之冠酒店是潘加西楠的隐藏瑰宝。泳池区域美丽宜人，房间一尘不染，服务无可挑剔。非常适合浪漫度假。"',
                    'es'  => '"El Hotel Royal Crest es una joya escondida en Pangasinan. El área de la piscina es hermosa, las habitaciones están impecables y el servicio es insuperable. Perfecto para una escapada romántica."',
                ],
                'guest_name' => [
                    'fil' => 'James Wilson', 'ja' => 'ジェームズ・ウィルソン', 'ko' => '제임스 윌슨', 'zh' => '詹姆斯·威尔逊', 'es' => 'James Wilson',
                ],
                'guest_location' => [
                    'fil' => 'Singapore', 'ja' => 'シンガポール', 'ko' => '싱가포르', 'zh' => '新加坡', 'es' => 'Singapur',
                ],
            ],
            3 => [
                'content' => [
                    'fil' => '"Nag-host kami ng wedding reception dito at ito ay mahiwagang karanasan. Ang event team ay higit pa sa inaasahan upang gawin ang aming espesyal na araw na perpekto. Ang ballroom ay talagang maganda!"',
                    'ja'  => '"ここでウェディングレセプションを開催しましたが、まさに魔法のようでした。イベントチームは私たちの特別な日を完璧にするために期待以上の努力をしてくれました。ボールルームは絶対的に素晴らしかったです！"',
                    'ko'  => '"이곳에서 웨딩 리셉션을 개최했는데 정말 마법 같았습니다. 이벤트 팀은 우리의 특별한 날을 완벽하게 만들기 위해 기대 이상의 노력을 해주었습니다. 볼룸은 정말 아름다웠어요!"',
                    'zh'  => '"我们在这里举办了婚宴，那是一段神奇的体验。活动团队超出我们的期望，让我们的特殊日子完美无瑕。宴会厅看起来绝对华丽！"',
                    'es'  => '"Celebramos aquí nuestra recepción de boda y fue mágico. El equipo de eventos hizo todo lo posible para que nuestro día especial fuera perfecto. ¡El salón de baile lucía absolutamente precioso!"',
                ],
                'guest_name' => [
                    'fil' => 'Ana Reyes', 'ja' => 'アナ・レイエス', 'ko' => '아나 레예스', 'zh' => '安娜·雷耶斯', 'es' => 'Ana Reyes',
                ],
                'guest_location' => [
                    'fil' => 'Cebu City, Pilipinas', 'ja' => 'セブシティ、フィリピン', 'ko' => '세부시티, 필리핀', 'zh' => '宿务市，菲律宾', 'es' => 'Cebú, Filipinas',
                ],
            ],
            4 => [
                'content' => [
                    'fil' => '"Magandang hotel para sa negosyo. Ang mga conference facilities ay moderno at well-equipped. Ang executive suite ay komportable at ang breakfast selection ay kahanga-hanga. Sulit ang presyo."',
                    'ja'  => '"ビジネスに最適なホテルです。会議施設は現代的で設備が充実しています。エグゼクティブスイートは快適で、朝食のセレクションも印象的でした。コストパフォーマンスも優秀です。"',
                    'ko'  => '"훌륭한 비즈니스 호텔입니다. 컨퍼런스 시설이 현대적이고 잘 갖추어져 있습니다. 이그제큐티브 스위트는 편안했고 조식 선택도 인상적이었습니다. 가성비가 좋습니다."',
                    'zh'  => '"非常好的商务酒店。会议设施现代且配备齐全。行政套房舒适，早餐种类令人印象深刻。物超所值。"',
                    'es'  => '"Excelente hotel de negocios. Las instalaciones para conferencias son modernas y bien equipadas. La suite ejecutiva fue cómoda y la selección de desayuno, impresionante. Buena relación calidad-precio."',
                ],
                'guest_name' => [
                    'fil' => 'David Chen', 'ja' => 'デビッド・チェン', 'ko' => '데이비드 첸', 'zh' => '陈大卫', 'es' => 'David Chen',
                ],
                'guest_location' => [
                    'fil' => 'Hong Kong', 'ja' => '香港', 'ko' => '홍콩', 'zh' => '香港', 'es' => 'Hong Kong',
                ],
            ],
            5 => [
                'content' => [
                    'fil' => '"Ang karanasan sa spa ay kahanga-hanga! Ang mga therapist ay napaka-skilled at ang ambiance ay napakarelax. Ang family suite ay perpekto para sa aming buong pamilya. Highly recommended!"',
                    'ja'  => '"スパ体験は最高でした！セラピストは非常に熟練していて、雰囲気は信じられないほどリラックスできます。ファミリースイートは家族全員に最適でした。強くお勧めします！"',
                    'ko'  => '"스파 경험이 정말 환상적이었습니다! 테라피스트들은 매우 숙련되어 있고 분위기가 믿을 수 없을 만큼 편안합니다. 패밀리 스위트는 온 가족에게 완벽했습니다. 강력 추천합니다!"',
                    'zh'  => '"水疗体验令人叫绝！治疗师技艺精湛，氛围极度放松。家庭套房非常适合全家入住。强烈推荐！"',
                    'es'  => '"¡La experiencia de spa fue divina! Los terapeutas son altamente cualificados y el ambiente es increíblemente relajante. La suite familiar fue perfecta para toda nuestra familia. ¡Muy recomendado!"',
                ],
                'guest_name' => [
                    'fil' => 'Grace Villanueva', 'ja' => 'グレース・ビジャヌエバ', 'ko' => '그레이스 비야누에바', 'zh' => '格蕾丝·比利亚努瓦', 'es' => 'Grace Villanueva',
                ],
                'guest_location' => [
                    'fil' => 'Dagupan City, PH', 'ja' => 'ダグパン市、フィリピン', 'ko' => '다구판시, 필리핀', 'zh' => '达古潘市，菲律宾', 'es' => 'Dagupán, Filipinas',
                ],
            ],
            6 => [
                'content' => [
                    'fil' => '"Napaka-komportable na pananatili. Malinis ang mga kwarto, magiliw ang mga kawani, at napakagandang pasilidad. Maginhawa ang lokasyon at masarap ang pagkain. Definitely babalik kami sa susunod na biyahe sa Pilipinas."',
                    'ja'  => '"とても快適な滞在でした。清潔なお部屋、フレンドリーなスタッフ、優れた施設。場所も便利で食事も美味しかったです。次のフィリピン旅行でも必ず利用します。"',
                    'ko'  => '"매우 편안한 숙박이었습니다. 깨끗한 방, 친절한 직원, 훌륭한 시설. 위치도 편리하고 음식도 맛있었습니다. 다음 필리핀 여행에서도 꼭 다시 예약하겠습니다."',
                    'zh'  => '"住宿非常舒适。房间干净，员工友好，设施出色。地理位置方便，食物美味。下次来菲律宾一定再预订。"',
                    'es'  => '"Estancia muy cómoda. Habitaciones limpias, personal amable y excelentes instalaciones. La ubicación es conveniente y la comida es deliciosa. Definitivamente reservaré de nuevo en mi próximo viaje a Filipinas."',
                ],
                'guest_name' => [
                    'fil' => 'Robert Kim', 'ja' => 'ロバート・キム', 'ko' => '로버트 김', 'zh' => '金罗伯特', 'es' => 'Robert Kim',
                ],
                'guest_location' => [
                    'fil' => 'South Korea', 'ja' => '韓国', 'ko' => '대한민국', 'zh' => '韩国', 'es' => 'Corea del Sur',
                ],
            ],
        ];

        foreach ($translations as $id => $data) {
            Testimonial::where('id', $id)->update([
                'content_translations'       => json_encode($data['content']),
                'guest_name_translations'    => json_encode($data['guest_name']),
                'guest_location_translations'=> json_encode($data['guest_location']),
            ]);
        }

        $this->info('  ✓ Testimonials done (' . count($translations) . ' entries)');
    }

    private function populateFacilities()
    {
        $this->info('Populating facility translations...');

        $translations = [
            1 => [
                'name' => [
                    'fil' => 'Swimming Pool',
                    'ja'  => 'スイミングプール',
                    'ko'  => '수영장',
                    'zh'  => '游泳池',
                    'es'  => 'Piscina',
                ],
                'description' => [
                    'fil' => 'Sumisid sa aming kahanga-hangang outdoor swimming pool na napapalibutan ng mayabong na tropical na hardin. Available para sa lahat ng bisita na may dedikadong lanes at mababaw na lugar para sa mga bata.',
                    'ja'  => '緑豊かなトロピカルガーデンに囲まれた素晴らしい屋外スイミングプールに飛び込みましょう。専用レーンとお子様用の浅いエリアを完備し、全ゲストにご利用いただけます。',
                    'ko'  => '울창한 열대 정원으로 둘러싸인 멋진 야외 수영장에 뛰어드세요. 전용 레인과 어린이용 얕은 구역을 갖추고 모든 투숙객에게 개방되어 있습니다.',
                    'zh'  => '跳入我们令人叹为观止的室外游泳池，四周环绕着郁郁葱葱的热带花园。向所有客人开放，设有专用泳道和儿童戏水浅水区。',
                    'es'  => 'Sumérgete en nuestra impresionante piscina al aire libre rodeada de exuberantes jardines tropicales. Disponible para todos los huéspedes con carriles dedicados y zona poco profunda para niños.',
                ],
            ],
            2 => [
                'name' => [
                    'fil' => 'Restaurant at Dining',
                    'ja'  => 'レストラン＆ダイニング',
                    'ko'  => '레스토랑 & 다이닝',
                    'zh'  => '餐厅与餐饮',
                    'es'  => 'Restaurante y Gastronomía',
                ],
                'description' => [
                    'fil' => 'Ang signature restaurant ng Royal Crest ay nagse-serve ng piling hanay ng Filipino at internasyonal na lutuin. Mula sa masustansiyang breakfast buffet hanggang sa romantikong candlelit dinner, ang aming culinary team ay gumagawa ng bawat putahe nang may pagmamahal.',
                    'ja'  => 'ロイヤルクレストのシグネチャーレストランでは、フィリピン料理と国際料理の精選されたメニューをご提供します。豪華な朝食ブッフェから親密なキャンドルライトディナーまで、料理チームが情熱を込めて一品一品を作り上げます。',
                    'ko'  => '로열 크레스트의 시그니처 레스토랑은 필리핀 요리와 국제 요리의 엄선된 메뉴를 제공합니다. 풍성한 조식 뷔페부터 로맨틱한 캔들라이트 디너까지, 요리팀이 정성을 다해 모든 요리를 만듭니다.',
                    'zh'  => '皇家之冠的标志性餐厅提供精心挑选的菲律宾和国际美食。从丰盛的早餐自助餐到浪漫的烛光晚餐，我们的烹饪团队用热情精心烹制每一道菜肴。',
                    'es'  => 'El restaurante insignia de Royal Crest sirve una exquisita variedad de cocina filipina e internacional. Desde buffets de desayuno hasta íntimas cenas a la luz de las velas, nuestro equipo culinario elabora cada plato con pasión.',
                ],
            ],
            3 => [
                'name' => [
                    'fil' => 'Fitness Center',
                    'ja'  => 'フィットネスセンター',
                    'ko'  => '피트니스 센터',
                    'zh'  => '健身中心',
                    'es'  => 'Centro de Fitness',
                ],
                'description' => [
                    'fil' => 'Panatilihin ang inyong wellness routine gamit ang state-of-the-art na kagamitan. Ang aming gym ay nagtatampok ng cardio machines, free weights, at dedikadong mga lugar para sa yoga at stretching.',
                    'ja'  => '最先端の設備でウェルネスルーティンを維持しましょう。ジムにはカーディオマシン、フリーウェイト、ヨガやストレッチ専用のゾーンが揃っています。',
                    'ko'  => '최첨단 장비로 웰니스 루틴을 유지하세요. 헬스장에는 유산소 운동 기구, 자유 중량, 요가 및 스트레칭 전용 구역이 갖추어져 있습니다.',
                    'zh'  => '使用最先进的设备保持您的健康日常。我们的健身房配备有氧运动器械、自由重量训练区以及专属瑜伽和拉伸区域。',
                    'es'  => 'Mantén tu rutina de bienestar con equipos de última generación. Nuestro gimnasio cuenta con máquinas de cardio, pesas libres y zonas dedicadas para yoga y estiramientos.',
                ],
            ],
            4 => [
                'name' => [
                    'fil' => 'Spa at Wellness',
                    'ja'  => 'スパ＆ウェルネス',
                    'ko'  => '스파 & 웰니스',
                    'zh'  => '水疗与健康',
                    'es'  => 'Spa y Bienestar',
                ],
                'description' => [
                    'fil' => 'Sumuko sa katahimikan sa Monarch Spa. Ang aming mga dalubhasang therapist ay nag-aalok ng curated na menu ng mga massage, body treatment, at facial gamit ang mga lokal at natural na sangkap.',
                    'ja'  => 'モナークスパで心の安らぎに身を委ねてください。経験豊富なセラピストが、地元産の天然素材を使用したマッサージ、ボディトリートメント、フェイシャルの精選されたメニューをご提供します。',
                    'ko'  => '모나크 스파에서 고요함에 몸을 맡기세요. 숙련된 테라피스트들이 현지에서 공수한 천연 재료를 사용한 마사지, 바디 트리트먼트, 페이셜의 엄선된 메뉴를 제공합니다.',
                    'zh'  => '在皇朝水疗中心沉浸于宁静之中。我们经验丰富的治疗师使用本地天然原料，提供精心策划的按摩、身体护理和面部护理服务。',
                    'es'  => 'Ríndete a la tranquilidad en el Monarch Spa. Nuestros expertos terapeutas ofrecen un menú seleccionado de masajes, tratamientos corporales y faciales con ingredientes naturales de origen local.',
                ],
            ],
            5 => [
                'name' => [
                    'fil' => 'Conference Hall',
                    'ja'  => 'コンファレンスホール',
                    'ko'  => '컨퍼런스 홀',
                    'zh'  => '会议厅',
                    'es'  => 'Salón de Conferencias',
                ],
                'description' => [
                    'fil' => 'Mag-host ng impactful na mga event sa aming fully equipped conference hall. Na may kapasidad na hanggang 500 bisita, state-of-the-art na AV systems, at dedikadong event coordinators.',
                    'ja'  => '設備完備のコンファレンスホールで効果的なイベントを開催しましょう。最大500名収容可能で、最先端のAVシステムと専任イベントコーディネーターが揃っています。',
                    'ko'  => '완벽하게 갖춰진 컨퍼런스 홀에서 임팩트 있는 이벤트를 개최하세요. 최대 500명 수용 가능하며, 최첨단 AV 시스템과 전담 이벤트 코디네이터를 갖추고 있습니다.',
                    'zh'  => '在我们设备齐全的会议厅举办有影响力的活动。最多可容纳500名宾客，配备最先进的视听系统和专职活动协调员。',
                    'es'  => 'Organice eventos impactantes en nuestro salón de conferencias totalmente equipado. Con capacidad para 500 personas, sistemas AV de última generación y coordinadores de eventos dedicados.',
                ],
            ],
            6 => [
                'name' => [
                    'fil' => 'Wedding Venue',
                    'ja'  => 'ウェディングベニュー',
                    'ko'  => '웨딩 베뉴',
                    'zh'  => '婚礼场地',
                    'es'  => 'Salón de Bodas',
                ],
                'description' => [
                    'fil' => 'Gawing totoo ang kasal ng inyong mga pangarap sa Monarch Hotel. Ang aming kahanga-hangang grand ballroom at garden venues ay nagbibigay ng perpektong setting para sa inyong pinaka-espesyal na araw.',
                    'ja'  => 'モナークホテルで夢のウェディングを実現しましょう。壮大なグランドボールルームとガーデンベニューが、あなたの最も特別な日に完璧な舞台を提供します。',
                    'ko'  => '모나크 호텔에서 꿈의 결혼식을 현실로 만드세요. 멋진 그랜드 볼룸과 정원 베뉴가 당신의 가장 특별한 날을 위한 완벽한 배경을 제공합니다.',
                    'zh'  => '在皇朝酒店创造梦想中的婚礼。我们华美的大宴会厅和花园场地为您最特别的日子提供完美背景。',
                    'es'  => 'Crea la boda de tus sueños en el Hotel Monarch. Nuestro impresionante gran salón de baile y jardines proporcionan el telón de fondo perfecto para tu día más especial.',
                ],
            ],
            7 => [
                'name' => [
                    'fil' => 'Libreng Parking',
                    'ja'  => '無料駐車場',
                    'ko'  => '무료 주차장',
                    'zh'  => '免费停车',
                    'es'  => 'Estacionamiento Gratuito',
                ],
                'description' => [
                    'fil' => 'Libreng secured parking para sa lahat ng in-house na bisita. Ang valet parking service ay available din sa kahilingan.',
                    'ja'  => '全宿泊ゲストに無料のセキュリティ駐車場をご用意しています。バレーパーキングサービスもご要望に応じてご利用いただけます。',
                    'ko'  => '모든 투숙 고객을 위한 무료 보안 주차장을 제공합니다. 발렛 파킹 서비스도 요청 시 이용 가능합니다.',
                    'zh'  => '为所有住店客人提供免费安保停车场。代客泊车服务也可应要求提供。',
                    'es'  => 'Estacionamiento seguro gratuito para todos los huéspedes. El servicio de valet parking también está disponible bajo solicitud.',
                ],
            ],
            8 => [
                'name' => [
                    'fil' => 'Airport Shuttle',
                    'ja'  => 'エアポートシャトル',
                    'ko'  => '공항 셔틀',
                    'zh'  => '机场班车',
                    'es'  => 'Traslado al Aeropuerto',
                ],
                'description' => [
                    'fil' => 'Maginhawang airport transfer service patungo at mula sa NAIA at Clark International Airport. Kailangan ng pre-booking.',
                    'ja'  => 'NAIAとクラーク国際空港への送迎サービスをご利用いただけます。事前予約が必要です。',
                    'ko'  => 'NAIA 및 클락 국제공항으로의 편리한 공항 이동 서비스를 제공합니다. 사전 예약이 필요합니다.',
                    'zh'  => '提供往来NAIA和克拉克国际机场的便捷接送服务。需提前预订。',
                    'es'  => 'Servicio de traslado conveniente hacia y desde NAIA y el Aeropuerto Internacional de Clark. Se requiere reserva previa.',
                ],
            ],
        ];

        foreach ($translations as $id => $data) {
            Facility::where('id', $id)->update([
                'name_translations'        => json_encode($data['name']),
                'description_translations' => json_encode($data['description']),
            ]);
        }

        $this->info('  ✓ Facilities done (' . count($translations) . ' entries)');
    }
}
