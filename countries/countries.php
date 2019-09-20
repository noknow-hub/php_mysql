<?php
//////////////////////////////////////////////////////////////////////
// countries.php
//
// MIT License
//
// Copyright (c) 2019 noknow.info
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in all
// copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
// INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
// PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
// OR THE USE OR OTHER DEALINGS IN THE SOFTW//ARE.
//////////////////////////////////////////////////////////////////////

namespace noknow\lib\db\mysql\countries;

use boolean;
use PDO;

class Countries {

    //////////////////////////////////////////////////////////////////////
    // Properties
    //////////////////////////////////////////////////////////////////////
    const TABLE_NAME = 'countries';
    const COL_COUNTRY_CODE = 'country_code';
    const COL_AR = 'ar';
    const COL_DE = 'de';
    const COL_EN = 'en';
    const COL_ES = 'es';
    const COL_FR = 'fr';
    const COL_JA = 'ja';
    const COL_KO = 'ko';
    const COL_PT = 'pt';
    const COL_RU = 'ru';
    const COL_ZHCN = 'zh_cn';
    const COL_ZHTW = 'zh_tw';
    const COL_CONTINENT = 'continent';
    const COL_STATUS = 'status';
    private $version;
    private $dbh;


    //////////////////////////////////////////////////////////////////////
    // Constructor
    //////////////////////////////////////////////////////////////////////
    public function __construct(object $dbh) {
        $this->version = phpversion();
        $this->dbh = $dbh;
    }


    //////////////////////////////////////////////////////////////////////
    // Initialize database.
    //////////////////////////////////////////////////////////////////////
    public function Init(): bool {
        $query = 'CREATE TABLE IF NOT EXISTS ' . self::TABLE_NAME .
                ' (' . self::COL_COUNTRY_CODE . ' VARCHAR(2) NOT NULL COMMENT "Country code of 2 digits",' .
                self::COL_AR . ' VARCHAR(255) NOT NULL COMMENT "Arabic",' .
                self::COL_DE . ' VARCHAR(255) NOT NULL COMMENT "German",' .
                self::COL_EN . ' VARCHAR(255) NOT NULL COMMENT "English",' .
                self::COL_ES . ' VARCHAR(255) NOT NULL COMMENT "Spanish",' .
                self::COL_FR . ' VARCHAR(255) NOT NULL COMMENT "French",' .
                self::COL_JA . ' VARCHAR(255) NOT NULL COMMENT "Japanese",' .
                self::COL_KO . ' VARCHAR(255) NOT NULL COMMENT "Korean",' .
                self::COL_PT . ' VARCHAR(255) NOT NULL COMMENT "Portuguese",' .
                self::COL_RU . ' VARCHAR(255) NOT NULL COMMENT "Russian",' .
                self::COL_ZHCN . ' VARCHAR(255) NOT NULL COMMENT "Chinese (Simplified Chinese)",' .
                self::COL_ZHTW . ' VARCHAR(255) NOT NULL COMMENT "Chinese (Traditional Chinese)",' .
                self::COL_CONTINENT . ' TINYINT(1) UNSIGNED NOT NULL COMMENT "1: Africa, 2: Asia, 3: Europe, 4: North America, 5: South America, 6: Australia / Oceania, 7: Antarctica",' .
                self::COL_STATUS . ' TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "0 inactive, 1: active",' .
                'PRIMARY KEY(' . self::COL_COUNTRY_CODE . ')' .
                ') ENGINE=InnoDB COMMENT="countriess table"';
        if($this->dbh->exec($query) === FALSE) {
            return FALSE;
        }

        $insertQuery = 'INSERT IGNORE INTO ' . self::TABLE_NAME .
                ' (' . self::COL_COUNTRY_CODE .
                ',' . self::COL_AR .
                ',' . self::COL_DE .
                ',' . self::COL_EN .
                ',' . self::COL_ES .
                ',' . self::COL_FR .
                ',' . self::COL_JA .
                ',' . self::COL_KO .
                ',' . self::COL_PT .
                ',' . self::COL_RU .
                ',' . self::COL_ZHCN .
                ',' . self::COL_ZHTW .
                ',' . self::COL_CONTINENT .
                ',' . self::COL_STATUS .
                ') VALUES' .
                ' ("AD","أندورا","Andorra","Andorra","Andorra","Andorre","アンドラ","안도라","Andorra","Андорра","安道尔","安道尔",3,1),' .
            ' ("AE","الإمارات العربية المتحدة","Vereinigte Arabische Emirate","United Arab Emirates","Emiratos Árabes Unidos","Émirats arabes unis","アラブ首長国連邦","아랍에미리트","Emirados Árabes Unidos","ОАЭ","阿联酋","阿联酋",2,1),' .
            ' ("AF","أفغانستان","Afghanistan","Afghanistan","Afganistán","Afghanistan","アフガニスタン","아프가니스탄","Afeganistão","Афганистан","阿富汗","阿富汗",2,1),' .
            ' ("AG","أنتيغوا وباربودا","Antigua und Barbuda","Antigua and Barbuda","Antigua y Barbuda","Antigua-et-Barbuda","アンティグア・バーブーダ","앤티가 바부다","Antígua e Barbuda","Антигуа и Барбуда","安地卡及巴布達","安地卡及巴布達",4,1),' .
            ' ("AI","أنغويلا","Anguilla","Anguilla","Anguila","Anguilla","アンギラ","앵귈라","Anguilla","Ангилья","安圭拉","安圭拉",4,1),' .
            ' ("AL","ألبانيا","Albanien","Albania","Albania","Albanie","アルバニア","알바니아","Albânia","Албания","阿尔巴尼亚","阿尔巴尼亚",3,1),' .
            ' ("AM","أرمينيا","Armenien","Armenia","Armenia","Arménie","アルメニア","아르메니아","Armênia","Армения","亞美尼亞","亞美尼亞",3,1),' .
            ' ("AO","أنغولا","Angola","Angola","Angola","Angola","アンゴラ","앙골라","Angola","Ангола","安哥拉","安哥拉",1,1),' .
            ' ("AQ","القارة القطبية الجنوبية","Antarktika","Antarctica","Antártida","Antarctique","南極","남극","Antártica","Антарктида","南极洲","南极洲",7,1),' .
            ' ("AR","الأرجنتين","Argentinien","Argentina","Argentina","Argentine","アルゼンチン","아르헨티나","Argentina","Аргентина","阿根廷","阿根廷",5,1),' .
            ' ("AS","ساموا الأمريكية","Amerikanisch-Samoa","American Samoa","Samoa Americana","Samoa américaines","アメリカ領サモア","아메리칸사모아","Samoa Americana","Американское Самоа","美属萨摩亚","美属萨摩亚",6,1),' .
            ' ("AT","النمسا","Österreich","Austria","Austria","Autriche","オーストリア","오스트리아","Áustria","Австрия","奥地利","奥地利",3,1),' .
            ' ("AU","أستراليا","Australien","Australia","Australia","Australie","オーストラリア","오스트레일리아","Austrália","Австралия","澳大利亚","澳大利亚",5,1),' .
            ' ("AW","أروبا","Aruba","Aruba","Aruba","Aruba","アルバ","아루바","Aruba","Аруба","阿鲁巴","阿鲁巴",4,1),' .
            ' ("AX","جزر أولاند","Åland","Åland Islands","Åland","les Åland","オーランド諸島","올란드 제도","Ilhas Aland","Аландские острова","奥兰","奥兰",1,1),' .
            ' ("AZ","أذربيجان","Aserbaidschan","Azerbaijan","Azerbaiyán","Azerbaïdjan","アゼルバイジャン","아제르바이잔","Azerbaijão","Азербайджан","阿塞拜疆","阿塞拜疆",3,1),' .
            ' ("BA","البوسنة والهرسك","Bosnien und Herzegowina","Bosnia and Herzegovina","Bosnia y Herzegovina","Bosnie-Herzégovine","ボスニア・ヘルツェゴビナ","보스니아 헤르체고비나","Bósnia e Herzegovina","Босния и Герцеговина","波斯尼亚和黑塞哥维那","波斯尼亚和黑塞哥维那",3,1),' .
            ' ("BB","باربادوس","Barbados","Barbados","Barbados","Barbade","バルバドス","바베이도스","Barbados","Барбадос","巴巴多斯","巴巴多斯",4,1),' .
            ' ("BD","بنغلاديش","Bangladesch","Bangladesh","Bangladés","Bangladesh","バングラデシュ","방글라데시","Bangladesh","Бангладеш","孟加拉国","孟加拉国",2,1),' .
            ' ("BE","بلجيكا","Belgien","Belgium","Bélgica","Belgique","ベルギー","벨기에","Bélgica","Бельгия","比利時","比利時",3,1),' .
            ' ("BF","بوركينا فاسو","Burkina Faso","Burkina Faso","Burkina Faso","Burkina Faso","ブルキナファソ","부르키나파소","Burkina Faso","Буркина-Фасо","布吉納法索","布吉納法索",1,1),' .
            ' ("BG","بلغاريا","Bulgarien","Bulgaria","Bulgaria","Bulgarie","ブルガリア","불가리아","Bulgária","Болгария","保加利亚","保加利亚",3,1),' .
            ' ("BH","البحرين","Bahrain","Bahrain","Baréin","Bahreïn","バーレーン","바레인","Barém","Бахрейн","巴林","巴林",2,1),' .
            ' ("BI","بوروندي","Burundi","Burundi","Burundi","Burundi","ブルンジ","부룬디","Burundi","Бурунди","布隆迪","布隆迪",1,1),' .
            ' ("BJ","بنين","Benin","Benin","Benín","Bénin","ベナン","베냉","Benin","Бенин","贝宁","贝宁",1,1),' .
            ' ("BL","سان بارتيلمي","Saint-Barthélemy","Saint Barthelemy","San Bartolomé","Saint-Barthélemy","サン・バルテルミー","생 바르 텔레 미","São Bartolomeu","Сен-Бартелеми","圣巴泰勒米","圣巴泰勒米",4,1),' .
            ' ("BM","برمودا","Bermuda","Bermuda","Bermudas","Bermudes","バミューダ","버뮤다","Bermudas","Бермуды","百慕大","百慕大",4,1),' .
            ' ("BN","بروناي","Brunei Darussalam","Brunei Darussalam","Brunéi","Brunei","ブルネイ・ダルサラーム","브루나이","Brunei Darussalam","Бруней","文莱","文莱",2,1),' .
            ' ("BO","بوليفيا","Bolivien","Bolivia","Bolivia","Bolivie","ボリビア多民族国","볼리비아","Bolívia","Боливия","玻利维亚","玻利维亚",5,1),' .
            ' ("BQ","الجزر الكاريبية الهولندية","Bonaire","Bonaire","Bonaire","Pays-Bas caribéens","ボネール","보네르","Bonaire","Бонэйр, Синт-Эстатиус и Саба","荷兰加勒比区","荷兰加勒比区",4,1),' .
            ' ("BR","البرازيل","Brasilien","Brazil","Brasil","Brésil","ブラジル","브라질","Brasil","Бразилия","巴西","巴西",5,1),' .
            ' ("BS","باهاماس","Bahamas","Bahamas","Bahamas","Bahamas","バハマ","바하마","Bahamas","Багамские Острова","巴哈马","巴哈马",4,1),' .
            ' ("BT","بوتان","Bhutan","Bhutan","Bután","Bhoutan","ブータン","부탄","Butão","Бутан","不丹","不丹",2,1),' .
            ' ("BV","جزيرة بوفيه","Bouvetinsel","Bouvet Island","Isla Bouvet","Île Bouvet","ブーベ島","부베섬","Ilha Bouvet","Остров Буве","布韦岛","布韦岛",7,1),' .
            ' ("BW","بوتسوانا","Botswana","Botswana","Botsuana","Botswana","ボツワナ","보츠와나","Botsuana","Ботсвана","博茨瓦纳","博茨瓦纳",1,1),' .
            ' ("BY","روسيا البيضاء","Belarus","Belarus","Bielorrusia","Biélorussie","ベラルーシ","벨라루스","Bielorrússia","Белоруссия","白俄羅斯","白俄羅斯",3,1),' .
            ' ("BZ","بليز","Belize","Belize","Belice","Belize","ベリーズ","벨리즈","Belize","Белиз","伯利兹","伯利兹",4,1),' .
            ' ("CA","كندا","Kanada","Canada","Canadá","Canada","カナダ","캐나다","Canadá","Канада","加拿大","加拿大",4,1),' .
            ' ("CC","جزر كوكوس","Kokosinseln","Cocos (Keeling) Islands","Islas Cocos","Îles Cocos","ココス (キーリング) 諸島","코코스 제도","Ilhas Cocos","Кокосовые острова","科科斯 (基林) 群島","科科斯 (基林) 群島",1,1),' .
            ' ("CD","جمهورية الكونغو الديمقراطية","Kongo, Demokratische Republik","Congo, Democratic Republic of the","República Democrática del Congo","République démocratique du Congo","コンゴ民主共和国","콩고 민주 공화국","Congo, República Democrática do","ДР Конго","刚果 (金)","刚果 (金)",1,1),' .
            ' ("CF","جمهورية أفريقيا الوسطى","Zentralafrikanische Republik","Central African Republic","República Centroafricana","République centrafricaine","中央アフリカ共和国","중앙아프리카 공화국","República Centro-Africana","ЦАР","中非","中非",1,1),' .
            ' ("CG","جمهورية الكونغو","Kongo, Republik","Congo","República del Congo","République du Congo","コンゴ共和国","콩고 공화국","Congo","Республика Конго","刚果 (布)","",1,1),' .
            ' ("CH","سويسرا","Schweiz","Switzerland","Suiza","Suisse","スイス","스위스","Suíço","Швейцария","瑞士","瑞士",3,1),' .
            ' ("CI","ساحل العاج","Côte d""Ivoire","Côte d""Ivoire","Costa de Marfil","Côte d""Ivoire","コートジボワール","코트디부아르","Costa do Marfim","Кот-д’Ивуар","科特迪瓦","科特迪瓦",1,1),' .
            ' ("CK","جزر كوك","Cookinseln","Cook Islands","Islas Cook","Îles Cook","クック諸島","쿡 제도","Ilhas Cook","Острова Кука","庫克群島","庫克群島",6,1),' .
            ' ("CL","تشيلي","Chile","Chile","Chile","Chili","チリ","칠레","Chile","Чили","智利","智利",5,1),' .
            ' ("CM","الكاميرون","Kamerun","Cameroon","Camerún","Cameroun","カメルーン","카메룬","Camarões","Камерун","喀麦隆","喀麦隆",1,1),' .
            ' ("CN","الصين","China","China","China","Chine","中華人民共和国","중국","China","Китай","中国","中国",2,1),' .
            ' ("CO","كولومبيا","Kolumbien","Colombia","Colombia","Colombie","コロンビア","콜롬비아","Colômbia","Колумбия","哥伦比亚","哥伦比亚",5,1),' .
            ' ("CR","كوستاريكا","Costa Rica","Costa Rica","Costa Rica","Costa Rica","コスタリカ","코스타리카","Costa Rica","Коста-Рика","哥斯达黎加","哥斯达黎加",4,1),' .
            ' ("CU","كوبا","Kuba","Cuba","Cuba","Cuba","キューバ","쿠바","Cuba","Куба","古巴","古巴",4,1),' .
            ' ("CV","الرأس الأخضر","Kap Verde","Cabo Verde","Cabo Verde","Cap-Vert","カーボベルデ","카보베르데","Cabo Verde","Кабо-Верде","佛得角","佛得角",1,1),' .
            ' ("CW","كوراساو","Curaçao","Curaçao","Curazao","Curaçao","キュラソー","쿠라 자오","Curaçao","Кюрасао","库拉索","库拉索",4,1),' .
            ' ("CX","جزيرة عيد الميلاد","Weihnachtsinsel","Christmas Island","Isla de Navidad","Île Christmas","クリスマス島","크리스마스 섬","Ilha do Natal","Остров Рождества","圣诞岛","圣诞岛",1,1),' .
            ' ("CY","قبرص","Zypern","Cyprus","Chipre","Chypre","キプロス","키프로스","Chipre","Кипр","賽普勒斯","賽普勒斯",3,1),' .
            ' ("CZ","جمهورية التشيك","Tschechien","Czech","República Checa","Tchéquie","チェコ","체코","Tcheca","Чехия","捷克","捷克",3,1),' .
            ' ("DE","ألمانيا","Deutschland","Germany","Alemania","Allemagne","ドイツ","독일","Alemanha","Германия","德國","德國",3,1),' .
            ' ("DJ","جيبوتي","Dschibuti","Djibouti","Yibuti","Djibouti","ジブチ","지부티","Djibuti","Джибути","吉布提","吉布提",1,1),' .
            ' ("DK","الدنمارك","Dänemark","Denmark","Dinamarca","Danemark","デンマーク","덴마크","Dinamarca","Дания","丹麥","丹麥",3,1),' .
            ' ("DM","دومينيكا","Dominica","Dominica","Dominica","Dominique","ドミニカ国","도미니카 연방","Dominica","Доминика","多米尼克","多米尼克",4,1),' .
            ' ("DO","جمهورية الدومينيكان","Dominikanische Republik","Dominican Republic","República Dominicana","République dominicaine","ドミニカ共和国","도미니카 공화국","República Dominicana","Доминиканская Республика","多米尼加","多米尼加",4,1),' .
            ' ("DZ","الجزائر","Algerien","Algeria","Argelia","Algérie","アルジェリア","알제리","Argélia","Алжир","阿尔及利亚","阿尔及利亚",1,1),' .
            ' ("EC","الإكوادور","Ecuador","Ecuador","Ecuador","Équateur","エクアドル","에콰도르","Equador","Эквадор","厄瓜多尔","厄瓜多尔",5,1),' .
            ' ("EE","إستونيا","Estland","Estonia","Estonia","Estonie","エストニア","에스토니아","Estônia","Эстония","爱沙尼亚","爱沙尼亚",3,1),' .
            ' ("EG","مصر","Ägypten","Egypt","Egipto","Égypte","エジプト","이집트","Egito","Египет","埃及","埃及",2,1),' .
            ' ("EH","الصحراء الغربية","Westsahara","Western Sahara","República Árabe Saharaui Democrática","République arabe sahraouie démocratique","西サハラ","서사하라","Saara Ocidental","САДР","西撒哈拉","西撒哈拉",1,1),' .
            ' ("ER","إريتريا","Eritrea","Eritrea","Eritrea","Érythrée","エリトリア","에리트레아","Eritreia","Эритрея","厄立特里亚","厄立特里亚",1,1),' .
            ' ("ES","إسبانيا","Spanien","Spain","España","Espagne","スペイン","스페인","Espanha","Испания","西班牙","西班牙",3,1),' .
            ' ("ET","إثيوبيا","Äthiopien","Ethiopia","Etiopía","Éthiopie","エチオピア","에티오피아","Etiópia","Эфиопия","衣索比亞","衣索比亞",1,1),' .
            ' ("FI","فنلندا","Finnland","Finland","Finlandia","Finlande","フィンランド","핀란드","Finlândia","Финляндия","芬兰","芬兰",3,1),' .
            ' ("FJ","فيجي","Fidschi","Fiji","Fiyi","Fidji","フィジー","피지","Fiji","Фиджи","斐济","斐济",6,1),' .
            ' ("FK","جزر فوكلاند","Falklandinseln","Falkland Islands (Malvinas)","Islas Malvinas","Malouines","フォークランド (マルビナス) 諸島","포클랜드 제도","Ilhas Falkland (Malvinas)","Фолклендские острова","福克蘭群島","福克蘭群島",5,1),' .
            ' ("FM","ولايات ميكرونيسيا المتحدة","Mikronesien","Micronesia (Federated States of)","Micronesia","États fédérés de Micronésie","ミクロネシア連邦","미크로네시아 연방","Micronésia (Estados Federados da)","Микронезия","密克羅尼西亞聯邦","密克羅尼西亞聯邦",6,1),' .
            ' ("FO","جزر فارو","Färöer","Faroe Islands","Islas Feroe","Îles Féroé","フェロー諸島","페로 제도","ilhas Faroe","Фареры","法罗群岛","法罗群岛",1,1),' .
            ' ("FR","فرنسا","Frankreich","France","Francia","France","フランス","프랑스","França","Франция","法国","法国",3,1),' .
            ' ("GA","الغابون","Gabun","Gabon","Gabón","Gabon","ガボン","가봉","Gabão","Габон","加彭","加彭",1,1),' .
            ' ("GB","المملكة المتحدة","Vereinigtes Königreich Großbritannien und Nordirland","United Kingdom","Reino Unido","Royaume-Uni","イギリス","영국","Reino Unido","Великобритания","英國","英國",3,1),' .
            ' ("GD","غرينادا","Grenada","Grenada","Granada","Grenade","グレナダ","그레나다","Granada","Гренада","格瑞那達","格瑞那達",4,1),' .
            ' ("GE","جورجيا","Georgien","Georgia","Georgia","Géorgie","ジョージア","조지아","Geórgia","Грузия","格鲁吉亚","格鲁吉亚",3,1),' .
            ' ("GF","غويانا الفرنسية","Französisch-Guayana","French Guiana","Guayana Francesa","Guyane","フランス領ギアナ","프랑스령 기아나","Guiana Francesa","Гвиана","法属圭亚那","法属圭亚那",5,1),' .
            ' ("GG","غيرنزي","Guernsey","Guernsey","Guernsey","Guernesey","ガーンジー","건지섬","Guernsey","Гернси","根西","根西",1,1),' .
            ' ("GH","غانا","Ghana","Ghana","Ghana","Ghana","ガーナ","가나","Gana","Гана","加纳","加纳",1,1),' .
            ' ("GI","جبل طارق","Gibraltar","Gibraltar","Gibraltar","Gibraltar","ジブラルタル","지브롤터","Gibraltar","Гибралтар","直布罗陀","直布罗陀",1,1),' .
            ' ("GL","جرينلاند","Grönland","Greenland","Groenlandia","Groenland","グリーンランド","그린란드","Gronelândia","Гренландия","格陵兰","格陵兰",4,1),' .
            ' ("GM","غامبيا","Gambia","Gambia","Gambia","Gambie","ガンビア","감비아","Gâmbia","Гамбия","冈比亚","冈比亚",1,1),' .
            ' ("GN","غينيا","Guinea","Guinea","Guinea","Guinée","ギニア","기니","Guiné","Гвинея","几内亚","几内亚",1,1),' .
            ' ("GP","غوادلوب","Guadeloupe","Guadeloupe","Guadalupe","Guadeloupe","グアドループ","과들루프","Guadalupe","Гваделупа","瓜德罗普","瓜德罗普",4,1),' .
            ' ("GQ","غينيا الاستوائية","Äquatorialguinea","Equatorial Guinea","Guinea Ecuatorial","Guinée équatoriale","赤道ギニア","적도 기니","Guiné Equatorial","Экваториальная Гвинея","赤道几内亚","赤道几内亚",1,1),' .
            ' ("GR","اليونان","Griechenland","Greece","Grecia","Grèce","ギリシャ","그리스","Grécia","Греция","希臘","希臘",3,1),' .
            ' ("GS","جورجيا الجنوبية وجزر ساندويتش الجنوبية","Südgeorgien und die Südlichen Sandwichinseln","South Georgia and the South Sandwich Islands","Islas Georgias del Sur y Sandwich del Sur","Géorgie du Sud-et-les îles Sandwich du Sud","サウスジョージア・サウスサンドウィッチ諸島","사우스조지아 사우스샌드위치 제도","Ilhas Geórgia do Sul e Sandwich do Sul","Южная Георгия и Южные Сандвичевы Острова","南乔治亚和南桑威奇群岛","南乔治亚和南桑威奇群岛",5,1),' .
            ' ("GT","غواتيمالا","Guatemala","Guatemala","Guatemala","Guatemala","グアテマラ","과테말라","Guatemala","Гватемала","危地马拉","危地马拉",4,1),' .
            ' ("GU","غوام","Guam","Guam","Guam","Guam","グアム","괌","Guam","Гуам","關島","關島",6,1),' .
            ' ("GW","غينيا بيساو","Guinea-Bissau","Guinea-Bissau","Guinea-Bisáu","Guinée-Bissau","ギニアビサウ","기니비사우","Guiné-Bissau","Гвинея-Бисау","几内亚比绍","几内亚比绍",1,1),' .
            ' ("GY","غيانا","Guyana","Guyana","Guyana","Guyana","ガイアナ","가이아나","Guiana","Гайана","圭亚那","圭亚那",5,1),' .
            ' ("HK","هونغ كونغ","Hongkong","Hong Kong","Hong Kong","Hong Kong","香港","홍콩","Hong Kong","Гонконг","香港","香港",2,1),' .
            ' ("HM","جزيرة هيرد وجزر ماكدونالد","Heard und McDonaldinseln","Heard Island and McDonald Islands","Islas Heard y McDonald","Îles Heard-et-MacDonald","ハード島とマクドナルド諸島","허드 맥도널드 제도","Ilha Heard e Ilhas McDonald","Херд и Макдональд","赫德岛和麦克唐纳群岛","赫德岛和麦克唐纳群岛",1,1),' .
            ' ("HN","هندوراس","Honduras","Honduras","Honduras","Honduras","ホンジュラス","온두라스","Honduras","Гондурас","洪都拉斯","洪都拉斯",4,1),' .
            ' ("HR","كرواتيا","Kroatien","Croatia","Croacia","Croatie","クロアチア","크로아티아","Croácia","Хорватия","克罗地亚","克罗地亚",3,1),' .
            ' ("HT","هايتي","Haiti","Haiti","Haití","Haïti","ハイチ","아이티","Haiti","Гаити","海地","海地",4,1),' .
            ' ("HU","المجر","Ungarn","Hungary","Hungría","Hongrie","ハンガリー","헝가리","Hungria","Венгрия","匈牙利","匈牙利",3,1),' .
            ' ("ID","إندونيسيا","Indonesien","Indonesia","Indonesia","Indonésie","インドネシア","인도네시아","Indonésia","Индонезия","印尼","印尼",2,1),' .
            ' ("IE","أيرلندا","Irland","Ireland","Irlanda","Irlande","アイルランド","아일랜드","Irlanda","Ирландия","爱尔兰","爱尔兰",3,1),' .
            ' ("IL","إسرائيل","Israel","Israel","Israel","Israël","イスラエル","이스라엘","Israel","Израиль","以色列","以色列",2,1),' .
            ' ("IM","جزيرة مان","Insel Man","Isle of Man","Isla de Man","Île de Man","マン島","맨섬","Ilha de Man","Остров Мэн","马恩岛","马恩岛",1,1),' .
            ' ("IN","الهند","Indien","India","India","Inde","インド","인도","Índia","Индия","印度","印度",2,1),' .
            ' ("IO","إقليم المحيط الهندي البريطاني","Britisches Territorium im Indischen Ozean","British Indian Ocean Territory","Territorio Británico del Océano Índico","Territoire britannique de l""océan Indien","イギリス領インド洋地域","영국령 인도양 지역","Território Britânico do Oceano Índico","Британская территория в Индийском океане","英屬印度洋領地","英屬印度洋領地",1,1),' .
            ' ("IQ","العراق","Irak","Iraq","Irak","Irak","イラク","이라크","Iraque","Ирак","伊拉克","伊拉克",2,1),' .
            ' ("IR","إيران","Iran, Islamische Republik","Iran (Islamic Republic of)","Irán","Iran","イラン・イスラム共和国","이란","Irã (Republic Islâmica do Irã)","Иран","伊朗","伊朗",2,1),' .
            ' ("IS","آيسلندا","Island","Iceland","Islandia","Islande","アイスランド","아이슬란드","Islândia","Исландия","冰島","冰島",3,1),' .
            ' ("IT","إيطاليا","Italien","Italy","Italia","Italie","イタリア","이탈리아","Itália","Италия","義大利","義大利",3,1),' .
            ' ("JE","جيرزي","Jersey","Jersey","Jersey","Jersey","ジャージー","저지섬","Jersey","Джерси","澤西","澤西",1,1),' .
            ' ("JM","جامايكا","Jamaika","Jamaica","Jamaica","Jamaïque","ジャマイカ","자메이카","Jamaica","Ямайка","牙买加","牙买加",4,1),' .
            ' ("JO","الأردن","Jordanien","Jordan","Jordania","Jordanie","ヨルダン","요르단","Jordânia","Иордания","约旦","约旦",2,1),' .
            ' ("JP","اليابان","Japan","Japan","Japón","Japon","日本","일본","Japão","Япония","日本","日本",2,1),' .
            ' ("KE","كينيا","Kenia","Kenya","Kenia","Kenya","ケニア","케냐","Quênia","Кения","肯尼亚","肯尼亚",1,1),' .
            ' ("KG","قيرغيزستان","Kirgisistan","Kyrgyzstan","Kirguistán","Kirghizistan","キルギス","키르기스스탄","Quirguistão","Киргизия","吉尔吉斯斯坦","吉尔吉斯斯坦",2,1),' .
            ' ("KH","كمبوديا","Kambodscha","Cambodia","Camboya","Cambodge","カンボジア","캄보디아","Camboja","Камбоджа","柬埔寨","柬埔寨",2,1),' .
            ' ("KI","كيريباتي","Kiribati","Kiribati","Kiribati","Kiribati","キリバス","키리바시","Kiribati","Кирибати","基里巴斯","基里巴斯",6,1),' .
            ' ("KM","جزر القمر","Komoren","Comoros","Comoras","Comores","コモロ","코모로","Comores","Коморы","科摩罗","科摩罗",1,1),' .
            ' ("KN","سانت كيتس ونيفيس","St. Kitts und Nevis","Saint Kitts and Nevis","San Cristóbal y Nieves","Saint-Christophe-et-Niévès","セントクリストファー・ネイビス","세인트키츠 네비스","São Cristóvão e Nevis","Сент-Китс и Невис","圣基茨和尼维斯","圣基茨和尼维斯",4,1),' .
            ' ("KP","كوريا الشمالية","Nordkorea","North Korea","Corea del Norte","Corée du Nord","朝鮮民主主義人民共和国","조선민주주의인민공화국","Coreia do Norte","КНДР (Корейская Народно-Демократическая Республика)","朝鲜","朝鲜",2,1),' .
            ' ("KR","كوريا الجنوبية","Südkorea","South Korea","Corea del Sur","Corée du Sud","大韓民国","대한민국","Coreia do Sul","Республика Корея","韩国","韩国",2,1),' .
            ' ("KW","الكويت","Kuwait","Kuwait","Kuwait","Koweït","クウェート","쿠웨이트","Kuwait","Кувейт","科威特","科威特",2,1),' .
            ' ("KY","جزر كايمان","Kaimaninseln","Cayman Islands","Islas Caimán","Îles Caïmans","ケイマン諸島","케이맨 제도","Ilhas Cayman","Острова Кайман","开曼群岛","开曼群岛",4,1),' .
            ' ("KZ","كازاخستان","Kasachstan","Kazakhstan","Kazajistán","Kazakhstan","カザフスタン","카자흐스탄","Cazaquistão","Казахстан","哈萨克斯坦","哈萨克斯坦",3,1),' .
            ' ("LA","لاوس","Laos","Laos","Laos","Laos","ラオス人民民主共和国","라오스","Laos","Лаос","老挝","老挝",2,1),' .
            ' ("LB","لبنان","Libanon","Lebanon","Líbano","Liban","レバノン","레바논","Líbano","Ливан","黎巴嫩","黎巴嫩",2,1),' .
            ' ("LC","سانت لوسيا","St. Lucia","Saint Lucia","Santa Lucía","Sainte-Lucie","セントルシア","세인트루시아","Santa Lúcia","Сент-Люсия","圣卢西亚","圣卢西亚",4,1),' .
            ' ("LI","ليختنشتاين","Liechtenstein","Liechtenstein","Liechtenstein","Liechtenstein","リヒテンシュタイン","리히텐슈타인","Liechtenstein","Лихтенштейн","列支敦斯登","列支敦斯登",1,1),' .
            ' ("LK","سريلانكا","Sri Lanka","Sri Lanka","Sri Lanka","Sri Lanka","スリランカ","스리랑카","Sri Lanka","Шри-Ланка","斯里蘭卡","斯里蘭卡",2,1),' .
            ' ("LR","ليبيريا","Liberia","Liberia","Liberia","Liberia","リベリア","라이베리아","Libéria","Либерия","利比里亚","利比里亚",1,1),' .
            ' ("LS","ليسوتو","Lesotho","Lesotho","Lesoto","Lesotho","レソト","레소토","Lesoto","Лесото","賴索托","賴索托",1,1),' .
            ' ("LT","ليتوانيا","Litauen","Lithuania","Lituania","Lituanie","リトアニア","리투아니아","Lituânia","Литва","立陶宛","立陶宛",3,1),' .
            ' ("LU","لوكسمبورغ","Luxemburg","Luxembourg","Luxemburgo","Luxembourg","ルクセンブルク","룩셈부르크","Luxemburgo","Люксембург","卢森堡","卢森堡",3,1),' .
            ' ("LV","لاتفيا","Lettland","Latvia","Letonia","Lettonie","ラトビア","라트비아","Letônia","Латвия","拉脫維亞","拉脫維亞",3,1),' .
            ' ("LY","ليبيا","Libyen","Libya","Libia","Libye","リビア","리비아","Líbia","Ливия","利比亞","利比亞",1,1),' .
            ' ("MA","المغرب","Marokko","Morocco","Marruecos","Maroc","モロッコ","모로코","Marrocos","Марокко","摩洛哥","摩洛哥",1,1),' .
            ' ("MC","موناكو","Monaco","Monaco","Mónaco","Monaco","モナコ","모나코","Mônaco","Монако","摩納哥","摩納哥",3,1),' .
            ' ("MD","مولدوفا","Moldawien","Moldova, Republic of","Moldavia","Moldavie","モルドバ共和国","몰도바","Moldávia, República da","Молдавия","摩尔多瓦","摩尔多瓦",3,1),' .
            ' ("ME","الجبل الأسود","Montenegro","Montenegro","Montenegro","Monténégro","モンテネグロ","몬테네그로","Montenegro","Черногория","蒙特內哥羅","蒙特內哥羅",3,1),' .
            ' ("MF","تجمع سان مارتين","Saint-Martin","Saint Martin (French part)","San Martín","Saint-Martin","サン・マルタン (フランス領)","세인트 마틴 (프랑스 령)","São Martinho (parte francesa)","Сен-Мартен","法属圣马丁","法属圣马丁",4,1),' .
            ' ("MG","مدغشقر","Madagaskar","Madagascar","Madagascar","Madagascar","マダガスカル","마다가스카르","Madagáscar","Мадагаскар","马达加斯加","马达加斯加",1,1),' .
            ' ("MH","جزر مارشال","Marshallinseln","Marshall Islands","Islas Marshall","Îles Marshall","マーシャル諸島","마셜 제도","Ilhas Marshall","Маршалловы Острова","马绍尔群岛","马绍尔群岛",6,1),' .
            ' ("MK","مقدونيا","Nordmazedonien","North Macedonia","Macedonia del Norte","Macédoine du Nord","北マケドニア","북마케도니아","Macedônia do Norte","Северная Македония","北馬其頓","北馬其頓",3,1),' .
            ' ("ML","مالي","Mali","Mali","Malí","Mali","マリ","말리","Mali","Мали","马里","马里",1,1),' .
            ' ("MM","ميانمار","Myanmar","Myanmar","Birmania","Birmanie","ミャンマー","미얀마","Myanmar","Мьянма","緬甸","緬甸",2,1),' .
            ' ("MN","منغوليا","Mongolei","Mongolia","Mongolia","Mongolie","モンゴル","몽골","Mongólia","Монголия","蒙古國","蒙古國",2,1),' .
            ' ("MO","ماكاو","Macau","Macao","Macao","Macao","マカオ","마카오","Macau","Макао","澳門","澳門",1,1),' .
            ' ("MP","جزر ماريانا الشمالية","Nördliche Marianen","Northern Mariana Islands","Islas Marianas del Norte","Îles Mariannes du Nord","北マリアナ諸島","북마리아나 제도","Ilhas Marianas do Norte","Северные Марианские Острова","北馬里亞納群島","北馬里亞納群島",6,1),' .
            ' ("MQ","مارتينيك","Martinique","Martinique","Martinica","Martinique","マルティニーク","마르티니크","Martinica","Мартиника","马提尼克","马提尼克",4,1),' .
            ' ("MR","موريتانيا","Mauretanien","Mauritania","Mauritania","Mauritanie","モーリタニア","모리타니","Mauritânia","Мавритания","毛里塔尼亚","毛里塔尼亚",1,1),' .
            ' ("MS","مونتسرات","Montserrat","Montserrat","Montserrat","Montserrat","モントセラト","몬트세랫","Montserrat","Монтсеррат","蒙特塞拉特","蒙特塞拉特",4,1),' .
            ' ("MT","مالطا","Malta","Malta","Malta","Malte","マルタ","몰타","Malta","Мальта","馬爾他","馬爾他",3,1),' .
            ' ("MU","موريشيوس","Mauritius","Mauritius","Mauricio","Maurice","モーリシャス","모리셔스","Maurícia","Маврикий","模里西斯","模里西斯",1,1),' .
            ' ("MV","جزر المالديف","Malediven","Maldives","Maldivas","Maldives","モルディブ","몰디브","Maldivas","Мальдивы","馬爾地夫","馬爾地夫",2,1),' .
            ' ("MW","مالاوي","Malawi","Malawi","Malaui","Malawi","マラウイ","말라위","Malawi","Малави","马拉维","马拉维",1,1),' .
            ' ("MX","المكسيك","Mexiko","Mexico","México","Mexique","メキシコ","멕시코","México","Мексика","墨西哥","墨西哥",4,1),' .
            ' ("MY","ماليزيا","Malaysia","Malaysia","Malasia","Malaisie","マレーシア","말레이시아","Malásia","Малайзия","马来西亚","马来西亚",2,1),' .
            ' ("MZ","موزمبيق","Mosambik","Mozambique","Mozambique","Mozambique","モザンビーク","모잠비크","Moçambique","Мозамбик","莫桑比克","莫桑比克",1,1),' .
            ' ("NA","ناميبيا","Namibia","Namibia","Namibia","Namibie","ナミビア","나미비아","Namíbia","Намибия","纳米比亚","纳米比亚",1,1),' .
            ' ("NC","كاليدونيا الجديدة","Neukaledonien","New Caledonia","Nueva Caledonia","Nouvelle-Calédonie","ニューカレドニア","누벨칼레도니","Nova Caledônia","Новая Каледония","新喀里多尼亞","新喀里多尼亞",6,1),' .
            ' ("NE","النيجر","Niger","Niger","Níger","Niger","ニジェール","니제르","Níger","Нигер","尼日尔","尼日尔",1,1),' .
            ' ("NF","جزيرة نورفولك","Norfolkinsel","Norfolk Island","Isla Norfolk","Île Norfolk","ノーフォーク島","노퍽섬","Ilha Norfolk","Остров Норфолк","诺福克岛","诺福克岛",6,1),' .
            ' ("NG","نيجيريا","Nigeria","Nigeria","Nigeria","Nigeria","ナイジェリア","나이지리아","Nigéria","Нигерия","奈及利亞","奈及利亞",1,1),' .
            ' ("NI","نيكاراغوا","Nicaragua","Nicaragua","Nicaragua","Nicaragua","ニカラグア","니카라과","Nicarágua","Никарагуа","尼加拉瓜","尼加拉瓜",4,1),' .
            ' ("NL","هولندا","Niederlande","Netherlands","Países Bajos","Pays-Bas","オランダ","네덜란드","Países Baixos","Нидерланды","荷蘭","荷蘭",3,1),' .
            ' ("NO","النرويج","Norwegen","Norway","Noruega","Norvège","ノルウェー","노르웨이","Noruega","Норвегия","挪威","挪威",3,1),' .
            ' ("NP","نيبال","Nepal","Nepal","Nepal","Népal","ネパール","네팔","Nepal","Непал","尼泊尔","尼泊尔",2,1),' .
            ' ("NR","ناورو","Nauru","Nauru","Nauru","Nauru","ナウル","나우루","Nauru","Науру","瑙鲁","瑙鲁",6,1),' .
            ' ("NU","نييوي","Niue","Niue","Niue","Niue","ニウエ","니우에","Niue","Ниуэ","纽埃","纽埃",6,1),' .
            ' ("NZ","نيوزيلندا","Neuseeland","New Zealand","Nueva Zelanda","Nouvelle-Zélande","ニュージーランド","뉴질랜드","Nova Zelândia","Новая Зеландия","新西蘭","新西蘭",6,1),' .
            ' ("OM","عمان","Oman","Oman","Omán","Oman","オマーン","오만","Omã","Оман","阿曼","阿曼",2,1),' .
            ' ("PA","بنما","Panama","Panama","Panamá","Panama","パナマ","파나마","Panamá","Панама","巴拿马","巴拿马",4,1),' .
            ' ("PE","بيرو","Peru","Peru","Perú","Pérou","ペルー","페루","Peru","Перу","秘魯","秘魯",5,1),' .
            ' ("PF","بولينزيا الفرنسية","Französisch-Polynesien","French Polynesia","Polinesia Francesa","Polynésie française","フランス領ポリネシア","프랑스령 폴리네시아","Polinésia Francesa","Французская Полинезия","法屬玻里尼西亞","法屬玻里尼西亞",6,1),' .
            ' ("PG","بابوا غينيا الجديدة","Papua-Neuguinea","Papua New Guinea","Papúa Nueva Guinea","Papouasie-Nouvelle-Guinée","パプアニューギニア","파푸아뉴기니","Papua Nova Guiné","Папуа — Новая Гвинея","巴布亚新几内亚","巴布亚新几内亚",6,1),' .
            ' ("PH","الفلبين","Philippinen","Philippines","Filipinas","Philippines","フィリピン","필리핀","Filipinos","Филиппины","菲律賓","菲律賓",2,1),' .
            ' ("PK","باكستان","Pakistan","Pakistan","Pakistán","Pakistan","パキスタン","파키스탄","Paquistão","Пакистан","巴基斯坦","巴基斯坦",2,1),' .
            ' ("PL","بولندا","Polen","Poland","Polonia","Pologne","ポーランド","폴란드","Polônia","Польша","波蘭","波蘭",3,1),' .
            ' ("PM","سان بيير وميكلون","Saint-Pierre und Miquelon","Saint Pierre and Miquelon","San Pedro y Miquelón","Saint-Pierre-et-Miquelon","サンピエール島・ミクロン島","생피에르 미클롱","São Pedro e Miquelon","Сен-Пьер и Микелон","圣皮埃尔和密克隆","圣皮埃尔和密克隆",4,1),' .
            ' ("PN","جزر بيتكيرن","Pitcairninseln","Pitcairn","Islas Pitcairn","Îles Pitcairn","ピトケアン","핏케언 제도","Pitcairn","Острова Питкэрн","皮特凯恩群岛","皮特凯恩群岛",1,1),' .
            ' ("PR","بورتوريكو","Puerto Rico","Puerto Rico","Puerto Rico","Porto Rico","プエルトリコ","푸에르토리코","Porto Rico","Пуэрто-Рико","波多黎各","波多黎各",4,1),' .
            ' ("PS","فلسطين","Staat Palästina","Palestine, State of","Palestina","Palestine","パレスチナ","팔레스타인","Palestina","Государство Палестина","巴勒斯坦","巴勒斯坦",2,1),' .
            ' ("PT","البرتغال","Portugal","Portugal","Portugal","Portugal","ポルトガル","포르투갈","Portugal","Португалия","葡萄牙","葡萄牙",3,1),' .
            ' ("PW","بالاو","Palau","Palau","Palaos","Palaos","パラオ","팔라우","Palau","Палау","帛琉","帛琉",6,1),' .
            ' ("PY","باراغواي","Paraguay","Paraguay","Paraguay","Paraguay","パラグアイ","파라과이","Paraguai","Парагвай","巴拉圭","巴拉圭",5,1),' .
            ' ("QA","قطر","Katar","Qatar","Catar","Qatar","カタール","카타르","Catar","Катар","卡塔尔","卡塔尔",2,1),' .
            ' ("RE","لا ريونيون","Réunion","Reunion","Reunión","La Réunion","レユニオン","레위니옹","Reunião","Реюньон","留尼汪","留尼汪",1,1),' .
            ' ("RO","رومانيا","Rumänien","Romania","Rumania","Roumanie","ルーマニア","루마니아","Romênia","Румыния","羅馬尼亞","羅馬尼亞",3,1),' .
            ' ("RS","صربيا","Serbien","Serbia","Serbia","Serbie","セルビア","세르비아","Sérvio","Сербия","塞爾維亞","塞爾維亞",3,1),' .
            ' ("RU","روسيا","Russische Föderation","Russia","Rusia","Russie","ロシア","러시아","Rússia","Россия","俄羅斯","俄羅斯",2,1),' .
            ' ("RW","رواندا","Ruanda","Rwanda","Ruanda","Rwanda","ルワンダ","르완다","Ruanda","Руанда","卢旺达","卢旺达",1,1),' .
            ' ("SA","السعودية","Saudi-Arabien","Saudi Arabia","Arabia Saudita","Arabie saoudite","サウジアラビア","사우디아라비아","Arábia Saudita","Саудовская Аравия","沙烏地阿拉伯","沙烏地阿拉伯",2,1),' .
            ' ("SB","جزر سليمان","Salomonen","Solomon Islands","Islas Salomón","Salomon","ソロモン諸島","솔로몬 제도","Ilhas Salomão","Соломоновы Острова","所罗门群岛","所罗门群岛",6,1),' .
            ' ("SC","سيشل","Seychellen","Seychelles","Seychelles","Seychelles","セーシェル","세이셸","Seychelles","Сейшельские Острова","塞舌尔","塞舌尔",1,1),' .
            ' ("SD","السودان","Sudan","Sudan","Sudán","Soudan","スーダン","수단","Sudão","Судан","苏丹","苏丹",1,1),' .
            ' ("SE","السويد","Schweden","Sweden","Suecia","Suède","スウェーデン","스웨덴","Suécia","Швеция","瑞典","瑞典",3,1),' .
            ' ("SG","سنغافورة","Singapur","Singapore","Singapur","Singapour","シンガポール","싱가포르","Cingapura","Сингапур","新加坡","新加坡",2,1),' .
            ' ("SH","سانت هيلانة وأسينشين وتريستان دا كونا","St. Helena","Saint Helena, Ascension and Tristan da Cunha","Santa Elena, Ascensión y Tristán de Acuña","Sainte-Hélène, Ascension et Tristan da Cunha","セントヘレナ・アセンションおよびトリスタンダクーニャ","세인트헬레나","Santa Helena, Ascensão e Tristão da Cunha","Острова Святой Елены, Вознесения и Тристан-да-Кунья","圣赫勒拿、阿森松和特里斯坦-达库尼亚","圣赫勒拿、阿森松和特里斯坦-达库尼亚",1,1),' .
            ' ("SI","سلوفينيا","Slowenien","Slovenia","Eslovenia","Slovénie","スロベニア","슬로베니아","Eslovênia","Словения","斯洛維尼亞","斯洛維尼亞",3,1),' .
            ' ("SJ","سفالبارد ويان ماين","Svalbard und Jan Mayen","Svalbard and Jan Mayen","Svalbard y Jan Mayen","Svalbard et ile Jan Mayen","スヴァールバル諸島およびヤンマイエン島","스발바르 얀마옌","Svalbard e Jan Mayen","Шпицберген и Ян-Майен","斯瓦尔巴和扬马延","斯瓦尔巴和扬马延",1,1),' .
            ' ("SK","سلوفاكيا","Slowakei","Slovakia","Eslovaquia","Slovaquie","スロバキア","슬로바키아","Eslováquia","Словакия","斯洛伐克","斯洛伐克",3,1),' .
            ' ("SL","سيراليون","Sierra Leone","Sierra Leone","Sierra Leona","Sierra Leone","シエラレオネ","시에라리온","Serra Leoa","Сьерра-Леоне","塞拉利昂","塞拉利昂",1,1),' .
            ' ("SM","سان مارينو","San Marino","San Marino","San Marino","Saint-Marin","サンマリノ","산마리노","San Marino","Сан-Марино","圣马力诺","圣马力诺",3,1),' .
            ' ("SN","السنغال","Senegal","Senegal","Senegal","Sénégal","セネガル","세네갈","Senegal","Сенегал","塞内加尔","塞内加尔",1,1),' .
            ' ("SO","الصومال","Somalia","Somalia","Somalia","Somalie","ソマリア","소말리아","Somália","Сомали","索馬利亞","索馬利亞",1,1),' .
            ' ("SR","سورينام","Suriname","Suriname","Surinam","Suriname","スリナム","수리남","Suriname","Суринам","苏里南","苏里南",5,1),' .
            ' ("SS","جنوب السودان","Südsudan","South Sudan","Sudán del Sur","Soudan du Sud","南スーダン","남수단","Sudão do Sul","Южный Судан","南蘇丹","南蘇丹",1,1),' .
            ' ("ST","ساو تومي وبرينسيب","São Tomé und Príncipe","Sao Tome and Principe","Santo Tomé y Príncipe","Sao Tomé-et-Principe","サントメ・プリンシペ","상투메 프린시페","São Tomé e Príncipe","Сан-Томе и Принсипи","聖多美和普林西比","聖多美和普林西比",1,1),' .
            ' ("SV","السلفادور","El Salvador","El Salvador","El Salvador","Salvador","エルサルバドル","엘살바도르","El Salvador","Сальвадор","薩爾瓦多","薩爾瓦多",4,1),' .
            ' ("SX","سينت مارتن","Sint Maarten","Sint Maarten (Dutch part)","San Martín","Saint-Martin","シント・マールテン (オランダ領)","신트마르턴","São Martinho (parte holandesa)","Синт-Мартен","聖馬丁","聖馬丁",4,1),' .
            ' ("SY","سوريا","Syrien","Syria","Siria","Syrie","シリア・アラブ共和国","시리아","Sírio","Сирия","叙利亚","叙利亚",2,1),' .
            ' ("SZ","سوازيلاند","Swasiland","Eswatini","Suazilandia","Swaziland","エスワティニ","에스와티니","Eswatini","Эсватини","斯威士兰","斯威士兰",1,1),' .
            ' ("TC","جزر توركس وكايكوس","Turks- und Caicosinseln","Turks and Caicos Islands","Islas Turcas y Caicos","Îles Turques-et-Caïques","タークス・カイコス諸島","터크스 케이커스 제도","Ilhas Turks e Caicos","Теркс и Кайкос","特克斯和凯科斯群岛","特克斯和凯科斯群岛",4,1),' .
            ' ("TD","تشاد","Tschad","Chad","Chad","Tchad","チャド","차드","Chade","Чад","乍得","乍得",1,1),' .
            ' ("TF","أراض فرنسية جنوبية وأنتارتيكية","Französische Süd- und Antarktisgebiete","French Southern Territories","Tierras Australes y Antárticas Francesas","Terres australes et antarctiques françaises","フランス領南方・南極地域","프랑스령 남방 및 남극","Territórios Franceses do Sul","Французские Южные и Антарктические Территории","法属南方和南极洲领地","法属南方和南极洲领地",7,1),' .
            ' ("TG","توغو","Togo","Togo","Togo","Togo","トーゴ","토고","Ir","Того","多哥","多哥",1,1),' .
            ' ("TH","تايلاند","Thailand","Thailand","Tailandia","Thaïlande","タイ","태국","Tailândia","Таиланд","泰國","泰國",2,1),' .
            ' ("TJ","طاجيكستان","Tadschikistan","Tajikistan","Tayikistán","Tadjikistan","タジキスタン","타지키스탄","Tajiquistão","Таджикистан","塔吉克斯坦","塔吉克斯坦",2,1),' .
            ' ("TK","توكيلاو","Tokelau","Tokelau","Tokelau","Tokelau","トケラウ","토켈라우","Tokelau","Токелау","托克勞","托克勞",6,1),' .
            ' ("TL","تيمور الشرقية","Timor-Leste","Timor-Leste","Timor Oriental","Timor oriental","東ティモール","동티모르","Timor-Leste","Восточный Тимор","东帝汶","东帝汶",2,1),' .
            ' ("TM","تركمانستان","Turkmenistan","Turkmenistan","Turkmenistán","Turkménistan","トルクメニスタン","투르크메니스탄","Turquemenistão","Туркмения","土库曼斯坦","土库曼斯坦",2,1),' .
            ' ("TN","تونس","Tunesien","Tunisia","Túnez","Tunisie","チュニジア","튀니지","Tunísia","Тунис","突尼西亞","突尼西亞",1,1),' .
            ' ("TO","تونغا","Tonga","Tonga","Tonga","Tonga","トンガ","통가","Tonga","Тонга","汤加","汤加",6,1),' .
            ' ("TR","تركيا","Türkei","Turkey","Turquía","Turquie","トルコ","터키","Turquia","Турция","土耳其","土耳其",2,1),' .
            ' ("TT","ترينيداد وتوباغو","Trinidad und Tobago","Trinidad and Tobago","Trinidad y Tobago","Trinité-et-Tobago","トリニダード・トバゴ","트리니다드 토바고","Trindade e Tobago","Тринидад и Тобаго","千里達及托巴哥","千里達及托巴哥",4,1),' .
            ' ("TV","توفالو","Tuvalu","Tuvalu","Tuvalu","Tuvalu","ツバル","투발루","Tuvalu","Тувалу","图瓦卢","图瓦卢",6,1),' .
            ' ("TW","تايوان","Taiwan","Taiwan","Taiwán","Taïwan","台湾","타이완","Taiwan","Китайская Республика","台湾","台湾",2,1),' .
            ' ("TZ","تنزانيا","Tansania, Vereinigte Republik","Tanzania, United Republic of","Tanzania","Tanzanie","タンザニア","탄자니아","Tanzânia, República Unida da","Танзания","坦桑尼亚","坦桑尼亚",1,1),' .
            ' ("UA","أوكرانيا","Ukraine","Ukraine","Ucrania","Ukraine","ウクライナ","우크라이나","Ucrânia","Украина","烏克蘭","烏克蘭",3,1),' .
            ' ("UG","أوغندا","Uganda","Uganda","Uganda","Ouganda","ウガンダ","우간다","Uganda","Уганда","乌干达","乌干达",1,1),' .
            ' ("UM","جزر الولايات المتحدة الصغيرة النائية","United States Minor Outlying Islands","United States Minor Outlying Islands","Islas ultramarinas de Estados Unidos","Îles mineures éloignées des États-Unis","合衆国領有小離島","미국령 군소 제도","Ilhas Menores Distantes dos Estados Unidos","Внешние малые острова (США)","美國本土外小島嶼","美國本土外小島嶼",1,1),' .
            ' ("US","الولايات المتحدة","Vereinigte Staaten von Amerika","United States of America","Estados Unidos","États-Unis","アメリカ合衆国","미국","Estados Unidos da America","США","美國","美國",4,1),' .
            ' ("UY","الأوروغواي","Uruguay","Uruguay","Uruguay","Uruguay","ウルグアイ","우루과이","Uruguai","Уругвай","乌拉圭","乌拉圭",5,1),' .
            ' ("UZ","أوزبكستان","Usbekistan","Uzbekistan","Uzbekistán","Ouzbékistan","ウズベキスタン","우즈베키스탄","Usbequistão","Узбекистан","乌兹别克斯坦","乌兹别克斯坦",2,1),' .
            ' ("VA","الفاتيكان","Vatikanstadt","Holy See","Ciudad del Vaticano","Saint-Siège","バチカン市国","바티칸 시국","Cidade do Vaticano","Ватикан","梵蒂冈","梵蒂冈",3,1),' .
            ' ("VC","سانت فينسنت والغرينادين","St. Vincent und die Grenadinen","Saint Vincent and the Grenadines","San Vicente y las Granadinas","Saint-Vincent-et-les-Grenadines","セントビンセントおよびグレナディーン諸島","세인트빈센트 그레나딘","São Vicente e Granadinas","Сент-Винсент и Гренадины","圣文森特和格林纳丁斯","圣文森特和格林纳丁斯",4,1),' .
            ' ("VE","فنزويلا","Venezuela","Venezuela (Bolivarian Republic of)","Venezuela","Venezuela","ベネズエラ・ボリバル共和国","베네수엘라","Venezuela","Венесуэла","委內瑞拉","委內瑞拉",5,1),' .
            ' ("VG","جزر العذراء البريطانية","Britische Jungferninseln","Virgin Islands (British)","Islas Vírgenes Británicas","Îles Vierges britanniques","イギリス領ヴァージン諸島","영국령 버진아일랜드","Ilhas Virgens Britânicas","Виргинские Острова (Великобритания)","英屬維爾京群島","英屬維爾京群島",4,1),' .
            ' ("VI","جزر العذراء الأمريكية","Amerikanische Jungferninseln","Virgin Islands (U.S.)","Islas Vírgenes de los Estados Unidos","Îles Vierges des États-Unis","アメリカ領ヴァージン諸島","미국령 버진아일랜드","Ilhas Virgens (EUA)","Виргинские Острова (США)","美屬維爾京群島","美屬維爾京群島",4,1),' .
            ' ("VN","فيتنام","Vietnam","Vietnam","Vietnam","Viêtnam","ベトナム","베트남","Vietnã","Вьетнам","越南","越南",2,1),' .
            ' ("VU","فانواتو","Vanuatu","Vanuatu","Vanuatu","Vanuatu","バヌアツ","바누아투","Vanuatu","Вануату","瓦努阿圖","瓦努阿圖",6,1),' .
            ' ("WF","والس وفوتونا","Wallis und Futuna","Wallis and Futuna","Wallis y Futuna","Wallis-et-Futuna","ウォリス・フツナ","왈리스 퓌튀나","Wallis e Futuna","Уоллис и Футуна","瓦利斯和富圖納","瓦利斯和富圖納",6,1),' .
            ' ("WS","ساموا","Samoa","Samoa","Samoa","Samoa","サモア","사모아","Samoa","Самоа","萨摩亚","萨摩亚",6,1),' .
            ' ("YE","اليمن","Jemen","Yemen","Yemen","Yémen","イエメン","예멘","Iémen","Йемен","葉門","葉門",2,1),' .
            ' ("YT","مايوت","Mayotte","Mayotte","Mayotte","Mayotte","マヨット","마요트","Mayotte","Майотта","马约特","马约特",1,1),' .
            ' ("ZA","جنوب أفريقيا","Südafrika","South Africa","Sudáfrica","Afrique du Sud","南アフリカ","남아프리카 공화국","África do Sul","ЮАР","南非","南非",1,1),' .
            ' ("ZM","زامبيا","Sambia","Zambia","Zambia","Zambie","ザンビア","잠비아","Zâmbia","Замбия","尚比亞","尚比亞",1,1),' .
            ' ("ZW","زيمبابوي","Simbabwe","Zimbabwe","Zimbabue","Zimbabwe","ジンバブエ","짐바브웨","Zimbábue","Зимбабве","辛巴威","辛巴威",1,1)';
        if($this->dbh->exec($insertQuery) === FALSE) {
            return FALSE;
        }
        
        
        return TRUE;
    }


    //////////////////////////////////////////////////////////////////////
    // Select
    //////////////////////////////////////////////////////////////////////
    public function Select(array $columns, string $langCode = NULL): ?array {
        $inputParams = array();
        $whereFlag = FALSE;
        if(is_null($langCode)) {
            $query = 'SELECT * FROM ' . self::TABLE_NAME;
        } else {
            $query = 'SELECT ' . $langCode .'  FROM ' . self::TABLE_NAME;
        }
        foreach($columns as $column => $value) {
            if($column === self::COL_COUNTRY_CODE ||
                    $column === self::COL_AR ||
                    $column === self::COL_DE ||
                    $column === self::COL_EN ||
                    $column === self::COL_ES ||
                    $column === self::COL_FR ||
                    $column === self::COL_JA ||
                    $column === self::COL_KO ||
                    $column === self::COL_PT ||
                    $column === self::COL_RU ||
                    $column === self::COL_ZHCN ||
                    $column === self::COL_ZHTW ||
                    $column === self::COL_CONTINENT ||
                    $column === self::COL_STATUS) {
                if(!$whereFlag) {
                    $query .= ' WHERE ' . $column . ' = :' . $column;
                    $whereFlag = TRUE;
                } else {
                    $query .= ' AND ' . $column . ' = :' . $column;
                }
                $inputParams[':' . $column] = $value;
            }
        }
        $sth = $this->dbh->prepare($query);
        if($sth === FALSE) {
            return NULL;
        }
        $res = $sth->execute($inputParams);
        if($res === FALSE) {
            return NULL;
        }
        $rows = $sth->fetchAll();
        return $rows;
    }


    //////////////////////////////////////////////////////////////////////
    // Get only active countries.
    //////////////////////////////////////////////////////////////////////
    public function GetOnlyActive(string $langCode = NULL): ?array {
        $columns = array(
            self::COL_STATUS => 1,
        );
        return $this->Select($columns, $langCode);
    }


    //////////////////////////////////////////////////////////////////////
    // Get only active countries in Africa.
    //////////////////////////////////////////////////////////////////////
    public function GetAfricaOnlyActive(string $langCode = NULL): ?array {
        $columns = array(
            self::COL_CONTINENT => 1,
            self::COL_STATUS => 1,
        );
        return $this->Select($columns, $langCode);
    }


    //////////////////////////////////////////////////////////////////////
    // Get only active countries in Asia.
    //////////////////////////////////////////////////////////////////////
    public functionGetAsiaOnlyActive(string $langCode = NULL): ?array {
        $columns = array(
            self::COL_CONTINENT => 2,
            self::COL_STATUS => 1,
        );
        return $this->Select($columns, $langCode);
    }


    //////////////////////////////////////////////////////////////////////
    // Get only active countries in Europe.
    //////////////////////////////////////////////////////////////////////
    public function GetEuropeOnlyActive(string $langCode = NULL): ?array {
        $columns = array(
            self::COL_CONTINENT => 3,
            self::COL_STATUS => 1,
        );
        return $this->Select($columns, $langCode);
    }


    //////////////////////////////////////////////////////////////////////
    // Get only active countries in North America.
    //////////////////////////////////////////////////////////////////////
    public function GetNorthAmericaOnlyActive(string $langCode = NULL): ?array {
        $columns = array(
            self::COL_CONTINENT => 4,
            self::COL_STATUS => 1,
        );
        return $this->Select($columns, $langCode);
    }


    //////////////////////////////////////////////////////////////////////
    // Get only active countries in South America.
    //////////////////////////////////////////////////////////////////////
    public function GetSouthAmericaOnlyActive(string $langCode = NULL): ?array {
        $columns = array(
            self::COL_CONTINENT => 5,
            self::COL_STATUS => 1,
        );
        return $this->Select($columns, $langCode);
    }


    //////////////////////////////////////////////////////////////////////
    // Get only active countries in Australia / Oceania.
    //////////////////////////////////////////////////////////////////////
    public function GetAustraliaOceaniaOnlyActive(string $langCode = NULL): ?array {
        $columns = array(
            self::COL_CONTINENT => 6,
            self::COL_STATUS => 1,
        );
        return $this->Select($columns, $langCode);
    }


    //////////////////////////////////////////////////////////////////////
    // Get only active countries in Antarctica.
    //////////////////////////////////////////////////////////////////////
    public function GetAntarcticaOnlyActive(string $langCode = NULL): ?array {
        $columns = array(
            self::COL_CONTINENT => 7,
            self::COL_STATUS => 1,
        );
        return $this->Select($columns, $langCode);
    }

}
