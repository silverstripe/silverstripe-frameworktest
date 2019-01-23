<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\Registry\RegistryDataInterface;

if (!interface_exists(RegistryDataInterface::class)) {
    return;
}

class TestRegistryDataObject extends DataObject implements RegistryDataInterface
{
    private static $table_name = 'TestRegistryDataObject';

    private static $db = [
        'Name' => 'Varchar',
        'PhoneNumber' => 'Varchar',
        'EmailAddress' => 'Varchar',
        'City' => 'Varchar',
        'RollSize' => 'Int',
    ];

    private static $searchable_fields = array(
        'Name',
        'City',
    );

    private static $summary_fields = [
        'Name', 'City', 'EmailAddress', 'City', 'RollSize'
    ];

    public function getSearchFields()
    {
        return new FieldList(
            new TextField('Name', 'School Name'),
            new TextField('City', 'City')
        );
    }

    public function requireDefaultRecords()
    {
        // Source: https://catalogue.data.govt.nz/dataset/directory-of-educational-institutions/resource/26f44973-b06d-479d-b697-8d7943c97c57
        $records = array (
            0 =>
                array (
                    'Name' => 'Oasis Family Preschool',
                    'PhoneNumber' => '03 528 8039',
                    'EmailAddress' => 'family@oasispreschools.co.nz',
                    'City' => 'Motueka',
                    'RollSize' => '30',
                ),
            1 =>
                array (
                    'Name' => 'Bell Street Early Learning Centre',
                    'PhoneNumber' => '06 308 8110',
                    'EmailAddress' => '',
                    'City' => 'Featherston',
                    'RollSize' => '23',
                ),
            2 =>
                array (
                    'Name' => 'Poipoi Home Child Care Limited',
                    'PhoneNumber' => '09 406 1056',
                    'EmailAddress' => 'alison@poipoi.co.nz',
                    'City' => 'Cable Bay',
                    'RollSize' => '60',
                ),
            3 =>
                array (
                    'Name' => 'BestStart Riverbend Road',
                    'PhoneNumber' => '06 843 4534',
                    'EmailAddress' => 'riverbend@best-start.org',
                    'City' => 'Napier',
                    'RollSize' => '75',
                ),
            4 =>
                array (
                    'Name' => 'Au Pair Link Taranaki 1',
                    'PhoneNumber' => '06 755 2655',
                    'EmailAddress' => '',
                    'City' => 'New Plymouth',
                    'RollSize' => '80',
                ),
            5 =>
                array (
                    'Name' => 'Home2Grow Childcare',
                    'PhoneNumber' => '0508 466 324',
                    'EmailAddress' => 'simran@home2grow.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '80',
                ),
            6 =>
                array (
                    'Name' => 'Otatara Preschool',
                    'PhoneNumber' => '03 213 0456',
                    'EmailAddress' => 'petrina@otatarapreschool.co.nz',
                    'City' => 'Invercargill',
                    'RollSize' => '65',
                ),
            7 =>
                array (
                    'Name' => 'First Steps Te Atatu',
                    'PhoneNumber' => '09 837 8439',
                    'EmailAddress' => 'fs.teatatu.manager@best-start.org',
                    'City' => 'Auckland',
                    'RollSize' => '63',
                ),
            8 =>
                array (
                    'Name' => 'Active Explorers Mana',
                    'PhoneNumber' => '04 233 1233',
                    'EmailAddress' => 'admin@ledu.co.nz',
                    'City' => 'Porirua',
                    'RollSize' => '77',
                ),
            9 =>
                array (
                    'Name' => 'Kindercare Learning Centres - Thomas Road',
                    'PhoneNumber' => '07 855 3667',
                    'EmailAddress' => 'thomasroad@kindercare.co.nz',
                    'City' => 'Hamilton',
                    'RollSize' => '100',
                ),
            10 =>
                array (
                    'Name' => 'Elim Early Learning Centre Cambridge',
                    'PhoneNumber' => '07 823 3216',
                    'EmailAddress' => 'karen.elimelc@gmail.com',
                    'City' => 'Cambridge',
                    'RollSize' => '60',
                ),
            11 =>
                array (
                    'Name' => 'Little Wonders St Kilda',
                    'PhoneNumber' => '',
                    'EmailAddress' => '',
                    'City' => 'Dunedin',
                    'RollSize' => '100',
                ),
            12 =>
                array (
                    'Name' => 'Little Footsteps-John Street',
                    'PhoneNumber' => '03 578 1416',
                    'EmailAddress' => 'info@littlefootsteps.co.nz',
                    'City' => 'Blenheim',
                    'RollSize' => '33',
                ),
            13 =>
                array (
                    'Name' => 'Childs Wonder',
                    'PhoneNumber' => '07 542 4602',
                    'EmailAddress' => 'info@childswonder.co.nz',
                    'City' => 'Tauranga',
                    'RollSize' => '43',
                ),
            14 =>
                array (
                    'Name' => 'Superstart Childcare',
                    'PhoneNumber' => '09 274 9226',
                    'EmailAddress' => 'leanalea@hotmail.com',
                    'City' => 'Auckland',
                    'RollSize' => '93',
                ),
            15 =>
                array (
                    'Name' => 'Fairy Godmothers Network 3',
                    'PhoneNumber' => '09 570 4110',
                    'EmailAddress' => '',
                    'City' => 'Stanmore Bay',
                    'RollSize' => '80',
                ),
            16 =>
                array (
                    'Name' => 'Just Kidz Educare - University',
                    'PhoneNumber' => '09 521 3040',
                    'EmailAddress' => 'info@justkidz.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '75',
                ),
            17 =>
                array (
                    'Name' => 'Lollipops Mount Albert',
                    'PhoneNumber' => '09 846 1046',
                    'EmailAddress' => 'cm.mtalbert@ledu.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '60',
                ),
            18 =>
                array (
                    'Name' => 'Active Explorers Blockhouse Bay',
                    'PhoneNumber' => '09 828 1525',
                    'EmailAddress' => 'cm.blockhousebay@activeexplorers.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '61',
                ),
            19 =>
                array (
                    'Name' => 'Rainbow Kidz Matamata',
                    'PhoneNumber' => '07 888 4235',
                    'EmailAddress' => '',
                    'City' => 'Matamata',
                    'RollSize' => '40',
                ),
            20 =>
                array (
                    'Name' => 'Kids Rock Early Learning Centre',
                    'PhoneNumber' => '07 883 1969',
                    'EmailAddress' => 'admin@kidsrock.net.nz',
                    'City' => 'Tirau',
                    'RollSize' => '50',
                ),
            21 =>
                array (
                    'Name' => 'Au Pair Link Christchurch 1',
                    'PhoneNumber' => '03 385 5259',
                    'EmailAddress' => 'cushla.watts@aupairlink.co.nz',
                    'City' => 'Christchurch',
                    'RollSize' => '80',
                ),
            22 =>
                array (
                    'Name' => 'Miro House Kindergarten ',
                    'PhoneNumber' => '07 855 8711',
                    'EmailAddress' => '',
                    'City' => 'Hamilton',
                    'RollSize' => '88',
                ),
            23 =>
                array (
                    'Name' => 'Kindercare Learning Centres - Sawyers Arms (213)',
                    'PhoneNumber' => '03 359 5511',
                    'EmailAddress' => '',
                    'City' => 'Christchurch',
                    'RollSize' => '80',
                ),
            24 =>
                array (
                    'Name' => 'Little Earth Montessori Kāpiti',
                    'PhoneNumber' => '04 298 1730',
                    'EmailAddress' => '',
                    'City' => 'Paraparaumu',
                    'RollSize' => '46',
                ),
            25 =>
                array (
                    'Name' => 'Ngongotaha Early Learning Centre',
                    'PhoneNumber' => '07 357 4044',
                    'EmailAddress' => '',
                    'City' => 'Rotorua',
                    'RollSize' => '60',
                ),
            26 =>
                array (
                    'Name' => 'Akoteu Matavai Sila\'i (Matavai Silai Pre School)',
                    'PhoneNumber' => '09 275 8365',
                    'EmailAddress' => 'akoteu@xtra.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '15',
                ),
            27 =>
                array (
                    'Name' => 'Pipis Childcare and Preschool',
                    'PhoneNumber' => '09 434 3044',
                    'EmailAddress' => 'info@pipis.co.nz',
                    'City' => 'Ngunguru',
                    'RollSize' => '47',
                ),
            28 =>
                array (
                    'Name' => 'Te Kōhanga Reo o Kākāriki',
                    'PhoneNumber' => '09 813 1412',
                    'EmailAddress' => '',
                    'City' => 'Auckland',
                    'RollSize' => '30',
                ),
            29 =>
                array (
                    'Name' => 'Montessori Beginnings Early Childhood Education Centre',
                    'PhoneNumber' => '09 428 2951',
                    'EmailAddress' => 'staff@montessoribeginnings.co.nz',
                    'City' => 'Whangaparaoa-Auckland',
                    'RollSize' => '30',
                ),
            30 =>
                array (
                    'Name' => 'Little Wonders Early Childhood Centre (Cromwell)',
                    'PhoneNumber' => '03 445 4550',
                    'EmailAddress' => 'cm.littlewonderscr@eeg.co.nz',
                    'City' => 'Cromwell',
                    'RollSize' => '56',
                ),
            31 =>
                array (
                    'Name' => 'Little Waikato Scholars Educare',
                    'PhoneNumber' => '07 843 6513',
                    'EmailAddress' => 'waikatoscholars@xtra.co.nz',
                    'City' => 'Hamilton',
                    'RollSize' => '50',
                ),
            32 =>
                array (
                    'Name' => 'Edukids Montel',
                    'PhoneNumber' => '09 836 2647',
                    'EmailAddress' => 'ek.montel.manager@best-start.org',
                    'City' => 'Auckland',
                    'RollSize' => '86',
                ),
            33 =>
                array (
                    'Name' => 'Kids Time Kindergarten',
                    'PhoneNumber' => '07 824 7373',
                    'EmailAddress' => '',
                    'City' => 'Ngaruawahia',
                    'RollSize' => '50',
                ),
            34 =>
                array (
                    'Name' => 'Fingerprints Christian Preschool',
                    'PhoneNumber' => '03 332 2001',
                    'EmailAddress' => 'info@fingerprints.school.nz',
                    'City' => 'Christchurch',
                    'RollSize' => '50',
                ),
            35 =>
                array (
                    'Name' => 'Dorie Community Preschool',
                    'PhoneNumber' => '03 302 0989',
                    'EmailAddress' => 'admin@doriepreschool.co.nz',
                    'City' => 'Rakaia',
                    'RollSize' => '36',
                ),
            36 =>
                array (
                    'Name' => 'BestStart Buchanans Road',
                    'PhoneNumber' => '03 741 1024',
                    'EmailAddress' => '',
                    'City' => 'Christchurch',
                    'RollSize' => '100',
                ),
            37 =>
                array (
                    'Name' => 'BestStart Petone',
                    'PhoneNumber' => '04 566 2278',
                    'EmailAddress' => 'petone@best-start.org',
                    'City' => 'Lower Hutt',
                    'RollSize' => '97',
                ),
            38 =>
                array (
                    'Name' => 'Active Explorers Central City',
                    'PhoneNumber' => '03 366 4307',
                    'EmailAddress' => 'admin.centralcity@activeexplorers.co.nz',
                    'City' => 'Christchurch',
                    'RollSize' => '67',
                ),
            39 =>
                array (
                    'Name' => 'White Heron Learning Centre - Otara',
                    'PhoneNumber' => '09 272 9939',
                    'EmailAddress' => 'jkhood@xtra.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '35',
                ),
            40 =>
                array (
                    'Name' => 'PORSE Hawke\'s Bay Q2',
                    'PhoneNumber' => '06 873 0033',
                    'EmailAddress' => '',
                    'City' => 'Havelock North',
                    'RollSize' => '80',
                ),
            41 =>
                array (
                    'Name' => 'Tots on Triton Early Childhood Centre',
                    'PhoneNumber' => '09 478 6333',
                    'EmailAddress' => 'info@tots.co.nz',
                    'City' => 'North Shore',
                    'RollSize' => '100',
                ),
            42 =>
                array (
                    'Name' => 'Spring Creek Playcentre',
                    'PhoneNumber' => '03 570 5514',
                    'EmailAddress' => '',
                    'City' => 'Spring Creek',
                    'RollSize' => '24',
                ),
            43 =>
                array (
                    'Name' => 'Somerset Early Learning Centre',
                    'PhoneNumber' => '07 863 3057',
                    'EmailAddress' => 'somersetchildcare@yahoo.com',
                    'City' => 'Waihi',
                    'RollSize' => '23',
                ),
            44 =>
                array (
                    'Name' => 'Junior Junction Albany',
                    'PhoneNumber' => '09 415 1665',
                    'EmailAddress' => 'albany@juniorjunction.co.nz',
                    'City' => 'North Shore City',
                    'RollSize' => '80',
                ),
            45 =>
                array (
                    'Name' => 'Kindercare Learning Centres - Massey',
                    'PhoneNumber' => '07 846 6644',
                    'EmailAddress' => 'massey@kindercare.co.nz',
                    'City' => 'Hamilton',
                    'RollSize' => '100',
                ),
            46 =>
                array (
                    'Name' => 'Home Grown Kids',
                    'PhoneNumber' => '07 578 2273',
                    'EmailAddress' => 'camille@edubase.co.nz',
                    'City' => 'Tauranga',
                    'RollSize' => '80',
                ),
            47 =>
                array (
                    'Name' => 'Riverside Educare Ltd',
                    'PhoneNumber' => '03 443 4073',
                    'EmailAddress' => 'riverside.educare@xnet.co.nz',
                    'City' => 'Albert Town',
                    'RollSize' => '65',
                ),
            48 =>
                array (
                    'Name' => 'Learning Adventures Waitara',
                    'PhoneNumber' => '06 759 4366',
                    'EmailAddress' => '',
                    'City' => 'Waitara',
                    'RollSize' => '60',
                ),
            49 =>
                array (
                    'Name' => 'Little Kiwis Playhouse Early Learning Centre ',
                    'PhoneNumber' => '09 948 2162',
                    'EmailAddress' => 'lkpnz@hotmail.com',
                    'City' => 'Auckland',
                    'RollSize' => '16',
                ),
            50 =>
                array (
                    'Name' => 'Tai Tamariki Kindergarten',
                    'PhoneNumber' => '04 802 4041',
                    'EmailAddress' => 'office@wmkindergartens.org.nz',
                    'City' => 'Wellington',
                    'RollSize' => '32',
                ),
            51 =>
                array (
                    'Name' => 'Paula\'s Tiny Tots Tahunanui',
                    'PhoneNumber' => '03 548 6285',
                    'EmailAddress' => 'paulastahuna@gmail.com',
                    'City' => 'Nelson',
                    'RollSize' => '15',
                ),
            52 =>
                array (
                    'Name' => 'Little Earth Montessori Queenstown',
                    'PhoneNumber' => '03 442 6567',
                    'EmailAddress' => 'queenstownmontessori@gmail.com',
                    'City' => 'Queenstown',
                    'RollSize' => '73',
                ),
            53 =>
                array (
                    'Name' => 'BestStart South Road 2',
                    'PhoneNumber' => '06 278 8366',
                    'EmailAddress' => 'southroad@best-start.org',
                    'City' => 'Hawera',
                    'RollSize' => '25',
                ),
            54 =>
                array (
                    'Name' => 'The Nurtury',
                    'PhoneNumber' => '03 349 4028',
                    'EmailAddress' => 'manager@thenurtury.co.nz',
                    'City' => 'Christchurch',
                    'RollSize' => '78',
                ),
            55 =>
                array (
                    'Name' => 'Ohope Beach Montessori Preschool',
                    'PhoneNumber' => '07 312 4819',
                    'EmailAddress' => 'ohopemontessori@hotmail.co.nz',
                    'City' => 'Ohope Beach',
                    'RollSize' => '30',
                ),
            56 =>
                array (
                    'Name' => 'Learning Days Childcare Limited',
                    'PhoneNumber' => '03 216 6224',
                    'EmailAddress' => 'learningdays@slingshot.co.nz',
                    'City' => 'Invercargill',
                    'RollSize' => '60',
                ),
            57 =>
                array (
                    'Name' => 'Lollipops Napier Port',
                    'PhoneNumber' => '06 834 0569',
                    'EmailAddress' => 'manager.lollipopsnp@eeg.co.nz',
                    'City' => 'Napier',
                    'RollSize' => '100',
                ),
            58 =>
                array (
                    'Name' => 'Childsplay Unlimited Kingsland',
                    'PhoneNumber' => '09 846 8908',
                    'EmailAddress' => 'childsplaychildcare@clear.net.nz',
                    'City' => 'Auckland',
                    'RollSize' => '61',
                ),
            59 =>
                array (
                    'Name' => 'Kids at Home The Bay 2',
                    'PhoneNumber' => '07 578 9816',
                    'EmailAddress' => '',
                    'City' => 'Tauranga',
                    'RollSize' => '60',
                ),
            60 =>
                array (
                    'Name' => 'Bright Horizons Drury',
                    'PhoneNumber' => '09 294 6139',
                    'EmailAddress' => 'drury@bhnewzealand.co.nz',
                    'City' => 'Drury',
                    'RollSize' => '46',
                ),
            61 =>
                array (
                    'Name' => 'BestStart Redwood ',
                    'PhoneNumber' => '03 354 3017',
                    'EmailAddress' => '',
                    'City' => 'Christchurch',
                    'RollSize' => '75',
                ),
            62 =>
                array (
                    'Name' => 'Cherry\'s on Maryhill',
                    'PhoneNumber' => '03 338 1999',
                    'EmailAddress' => 'cherry@cherrys.co.nz',
                    'City' => 'Christchurch',
                    'RollSize' => '45',
                ),
            63 =>
                array (
                    'Name' => 'Te Puawaitanga o Ngati Ruanui ECE',
                    'PhoneNumber' => '06 278 3529',
                    'EmailAddress' => 'makere.gerrad@ngatiruanui.org',
                    'City' => 'Hawera',
                    'RollSize' => '40',
                ),
            64 =>
                array (
                    'Name' => 'Adventureland Early Learning Centre',
                    'PhoneNumber' => '09 580 0587',
                    'EmailAddress' => 'info@adventureland.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '60',
                ),
            65 =>
                array (
                    'Name' => 'PORSE Otago/Southland Q1',
                    'PhoneNumber' => '09 438 5100',
                    'EmailAddress' => '',
                    'City' => 'Auckland',
                    'RollSize' => '80',
                ),
            66 =>
                array (
                    'Name' => 'Newton Street Childcare Ltd',
                    'PhoneNumber' => '07 575 8727',
                    'EmailAddress' => 'newtonstcc@orcon.net.nz',
                    'City' => 'Tauranga',
                    'RollSize' => '45',
                ),
            67 =>
                array (
                    'Name' => 'Biggles Childcare',
                    'PhoneNumber' => '09 813 3595',
                    'EmailAddress' => 'biggleschildcare@xtra.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '40',
                ),
            68 =>
                array (
                    'Name' => 'Little Bears Early Childhood Education & Care Centre ',
                    'PhoneNumber' => '09 266 0203',
                    'EmailAddress' => 'office@littlebears.co.nz',
                    'City' => 'Auckland',
                    'RollSize' => '50',
                ),
            69 =>
                array (
                    'Name' => 'Reach Forward Early Learning Centre',
                    'PhoneNumber' => '09 950 4400',
                    'EmailAddress' => '',
                    'City' => 'North Shore City',
                    'RollSize' => '47',
                ),
            70 =>
                array (
                    'Name' => 'BestStart Railway Road',
                    'PhoneNumber' => '06 356 2516',
                    'EmailAddress' => 'railway@best-start.org',
                    'City' => 'Palmerston North',
                    'RollSize' => '70',
                ),
            71 =>
                array (
                    'Name' => 'Educarents Canterbury',
                    'PhoneNumber' => '0800 100 029',
                    'EmailAddress' => 'lynette@educarents.com',
                    'City' => 'Rolleston',
                    'RollSize' => '80',
                ),
            72 =>
                array (
                    'Name' => 'Koru Kindergarten',
                    'PhoneNumber' => '06 765 6051',
                    'EmailAddress' => 'koru@kindergartentaranaki.co.nz',
                    'City' => 'Stratford',
                    'RollSize' => '42',
                ),
            73 =>
                array (
                    'Name' => 'The Miller Nest Early Learning Centre',
                    'PhoneNumber' => '09 636 0305',
                    'EmailAddress' => 'bolaz.biz@gmail.com',
                    'City' => 'Auckland',
                    'RollSize' => '35',
                ),
            74 =>
                array (
                    'Name' => 'Little Ones Preschool',
                    'PhoneNumber' => '03 312 8122',
                    'EmailAddress' => '',
                    'City' => 'Loburn',
                    'RollSize' => '62',
                ),
            75 =>
                array (
                    'Name' => 'Te Kōhanga Reo o Āniwaniwa ',
                    'PhoneNumber' => '09 409 5010',
                    'EmailAddress' => '',
                    'City' => 'Kaitaia',
                    'RollSize' => '40',
                ),
            76 =>
                array (
                    'Name' => 'Cashmere Early Learning Centre',
                    'PhoneNumber' => '03 321 7299',
                    'EmailAddress' => '',
                    'City' => 'Christchurch',
                    'RollSize' => '28',
                ),
            77 =>
                array (
                    'Name' => 'Eden Early Learning',
                    'PhoneNumber' => '03 546 5359',
                    'EmailAddress' => 'edenearlylearningltd@gmail.com',
                    'City' => 'Nelson',
                    'RollSize' => '76',
                ),
            78 =>
                array (
                    'Name' => 'Nurtured at Home-Wellington 1',
                    'PhoneNumber' => '04 801 2890',
                    'EmailAddress' => 'petra@nurturedathome.co.nz',
                    'City' => 'Wellington',
                    'RollSize' => '50',
                ),
            79 =>
                array (
                    'Name' => 'PAUA Early Childhood 9',
                    'PhoneNumber' => '06 344 7282',
                    'EmailAddress' => 'info@paua.ac.nz',
                    'City' => 'Whanganui',
                    'RollSize' => '80',
                ),
            80 =>
                array (
                    'Name' => 'BestStart Motutaiko Street',
                    'PhoneNumber' => '07 376 5681',
                    'EmailAddress' => '',
                    'City' => 'Taupo',
                    'RollSize' => '61',
                ),
            81 =>
                array (
                    'Name' => 'BestStart Glasgow Street',
                    'PhoneNumber' => '06 345 3804',
                    'EmailAddress' => 'glasgow@best-start.org',
                    'City' => 'Whanganui',
                    'RollSize' => '110',
                ),
            82 =>
                array (
                    'Name' => 'Farmhouse Preschool Patumahoe',
                    'PhoneNumber' => '09 236 3003',
                    'EmailAddress' => 'office@farmhousepreschool.co.nz',
                    'City' => 'Pukekohe',
                    'RollSize' => '30',
                ),
            83 =>
                array (
                    'Name' => 'Kids at Home The Bay 3',
                    'PhoneNumber' => '07 578 9816',
                    'EmailAddress' => '',
                    'City' => 'Tauranga',
                    'RollSize' => '60',
                ),
            84 =>
                array (
                    'Name' => 'Giggles Learning Centre',
                    'PhoneNumber' => '09 437 6353',
                    'EmailAddress' => 'giggleslearningcentre@xtra.co.nz',
                    'City' => 'Whangarei',
                    'RollSize' => '33',
                ),
            85 =>
                array (
                    'Name' => 'Te Puna Reo O Puhi Kaiti',
                    'PhoneNumber' => '06 868 8182',
                    'EmailAddress' => '',
                    'City' => 'Gisborne',
                    'RollSize' => '37',
                ),
            86 =>
                array (
                    'Name' => 'The Tree House ',
                    'PhoneNumber' => '07 307 7155',
                    'EmailAddress' => 'yscott@xtra.co.nz',
                    'City' => 'Whakatane',
                    'RollSize' => '27',
                ),
            87 =>
                array (
                    'Name' => 'HoNey BeeZ Preschool & Nursery',
                    'PhoneNumber' => '03 327 5683',
                    'EmailAddress' => 'honeybeez.preschool@windowslive.com',
                    'City' => 'Kaiapoi',
                    'RollSize' => '35',
                ),
            88 =>
                array (
                    'Name' => 'BestStart Halswell Road',
                    'PhoneNumber' => '03 322 5139',
                    'EmailAddress' => '',
                    'City' => 'Christchurch',
                    'RollSize' => '75',
                ),
            89 =>
                array (
                    'Name' => 'PAUA Early Childhood 8',
                    'PhoneNumber' => '06 344 7282',
                    'EmailAddress' => 'info@paua.ac.nz',
                    'City' => 'Whanganui',
                    'RollSize' => '80',
                ),
            90 =>
                array (
                    'Name' => 'Akoteu Lotofaleia Under 2s',
                    'PhoneNumber' => '09 257 2030',
                    'EmailAddress' => '',
                    'City' => 'Auckland',
                    'RollSize' => '25',
                ),
            91 =>
                array (
                    'Name' => 'Sunshine Childcare  Preschool',
                    'PhoneNumber' => '07 849 2020',
                    'EmailAddress' => 'info@sunshinechildcare.co.nz',
                    'City' => 'Hamilton',
                    'RollSize' => '126',
                ),
            92 =>
                array (
                    'Name' => 'Little Orchard Preschool - McGarvey Road 1',
                    'PhoneNumber' => '07 308 7777',
                    'EmailAddress' => 'generalmanager@lops.co.nz',
                    'City' => 'Whakatane',
                    'RollSize' => '30',
                ),
            93 =>
                array (
                    'Name' => 'Castle Kids-Ruru',
                    'PhoneNumber' => '04 905 5437',
                    'EmailAddress' => 'info@castlekids.co.nz',
                    'City' => 'Waikanae',
                    'RollSize' => '28',
                ),
            94 =>
                array (
                    'Name' => 'BestStart Mangorei Road',
                    'PhoneNumber' => '06 757 3687',
                    'EmailAddress' => '',
                    'City' => 'New Plymouth',
                    'RollSize' => '75',
                ),
            95 =>
                array (
                    'Name' => 'Parua Bay Childcare ',
                    'PhoneNumber' => '09 436 5544',
                    'EmailAddress' => 'paruabaycc@xtra.co.nz',
                    'City' => 'Parua Bay',
                    'RollSize' => '60',
                ),
            96 =>
                array (
                    'Name' => 'BestStart Montessori St Albans',
                    'PhoneNumber' => '03 356 0111',
                    'EmailAddress' => '',
                    'City' => 'Christchurch',
                    'RollSize' => '48',
                ),
            97 =>
                array (
                    'Name' => 'ELCM Alfriston College ',
                    'PhoneNumber' => '09 267 2450',
                    'EmailAddress' => '',
                    'City' => 'Auckland',
                    'RollSize' => '50',
                ),
            98 =>
                array (
                    'Name' => 'Kid\'s Land Educare Centre',
                    'PhoneNumber' => '09 820 3346',
                    'EmailAddress' => 'kidsland.educare@gmail.com',
                    'City' => 'Auckland',
                    'RollSize' => '65',
                ),
            99 =>
                array (
                    'Name' => 'Pascals Albany',
                    'PhoneNumber' => '09 478 5081',
                    'EmailAddress' => 'cm.albany@pascalselc.co.nz',
                    'City' => 'North Shore City',
                    'RollSize' => '125',
                ),
            100 =>
                array (
                    'Name' => 'Titirangi Private Kindergarten - Rural Campus',
                    'PhoneNumber' => '09 817 4304',
                    'EmailAddress' => '',
                    'City' => 'Waitakere',
                    'RollSize' => '39',
                ),
        );

        /** @var DataObject[] $all */
        $all = static::get();
        foreach ($all as $one) {
            $one->delete();
        }

        foreach ($records as $record) {
            $new = new static;
            $new->update($record);
            $new->write();
        }

        DB::alteration_message('Added default records to DefaultRegistryDataObject table', 'created');
    }
}
