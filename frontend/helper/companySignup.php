<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 26.04.15
 * Time: 14:38
 * Project: hireMe
 */


// Attention: If you add/remove entries, remember to adapt the validator in SignupForm.php
$sectors = [
    'A' => [
        1=>'Anlagen-/ Maschinenbau',
        2=>'Automobile',
        3=>'Automobilproduktion',
        4=>'Automobilzulieferer',
    ],
    'B' => [
        5=>'Banken',
        6=>'Bau-Zulieferer / Baustoffe',
        7=>'Baudienstleister',
        8=>'Bauhauptgewerbe',
        9=>'Bekleidung / Textilien / Schuhe',
        10=>'Bildung und Forschung',
        11=>'Biotechnologie',
        12=>'Brief- / Paketdienste',
    ],
    'C' => [
        13=>'Chemie',
        14=>'Chiphersteller / Halbleiter',
    ],
    'D' => [
        15=>'Datenspeicherung',
        16=>'Dienstleistungen',
    ],
    'E' => [
        17=>'E-Commerce-Software',
        18=>'Einzelhandel',
        19=>'Elektroausstattung',
        20=>'Elektronische Bauelemente',
        21=>'Elektrotechnologie',
        22=>'Energie',
        23=>'Erneuerbare Energien',
    ],
    'F' => [
        24=>'Finanzdienstleister',
        25=>'Fluggesellschaften',
    ],
    'G' => [
        26=>'Gerätehersteller',
        27=>'Gesundheitsdienstleister',
        28=>'Getränke / Tabak',
        29=>'Großhandel',
        30=>'Gütertransport',
    ],
    'H' => [
        31=>'Handel',
        32=>'Hardware',
        33=>'Holdings / Mischkonzerne',
        34=>'Holzindustrie / Holzverarbeitung',
        35=>'Hotelgewerbe'
    ],
    'I' => [
        36=>'Immobilien',
        37=>'Industrie',
        38=>'Industriedienstleister',
        39=>'Informationstechnologie',
        40=>'Ingenieurdienstleister',
        41=>'Internet-Dienstleister',
        42=>'Internethandel (B2B, B2C)',
        43=>'IT-Beratung',
        44=>'IT-Dienstleister',
        45=>'IT-Software'
    ],
    'K' => [
        46=>'Kaufhäuser',
        47=>'Konsumgüter',
        48=>'Kunststoffe',
    ],
    'L' => [
        49=>'Lichttechnik',
        50=>'Logistik',
        51=>'Luft- und Raumfahrt',
        52=>'Luxusgüter',
    ],
    'M' => [
        53=>'Medien / Entertainment',
        54=>'Medizinische Produkte / Medizintechnik',
        55=>'Metallverarbeitung',
        56=>'Möbel / Einrichtung',
        57=>'Mobilkommunikation',
    ],
    'N' => [
        58=>'Nahrung / Restaurant',
        59=>'Nanotechnologie',
        60=>'Netzbetreiber',
        61=>'Netzwerkaufbau / -ausrüster',
        62=>'Netzwerktechnik',
        63=>'Nutzfahrzeuge',
    ],
    'O' => [
        64=>'Ökoprodukte',
        65=>'Öl / Gas',
        66=>'Outsourcing',
    ],
    'P' => [
        67=>'Papier- / Kartonindustrie',
        68=>'PCs',
        69=>'Personaldienstleister',
        70=>'Pharma',
    ],
    'R' => [
        71=>'Rechte',
        72=>'Receycling',
        73=>'Rohstoffe',
        74=>'Rohstoffförderung',
        75=>'Rückversicherungen',
        76=>'Rüstungsindustrie'
    ],
    'S' => [
        77=>'Schiffbau',
        78=>'Schifffahrt',
        79=>'Server / Großrechner',
        80=>'Software',
        81=>'Softwareservice / -dienstleistungen',
        82=>'Spezialchemie',
        83=>'Sportartikel',
        84=>'Stahl- / Metallindustrie',
        85=>'Straßen / Schienen',
        86=>'Supermärkte',
    ],
    'T' => [
        87=>'Telekommunikation',
        88=>'Telekommunikationsausrüster',
        89=>'Touristik',
    ],
    'U' => [
        90=>'Umwelt-Dienstleister',
        91=>'Umweltschutztechnologie',
        92=>'Unterhaltungselektronik',
        93=>'Unternehmensberatung',
        94=>'Unternehmensbeteiligungen',
    ],
    'V' => [
        95=>'Venture Capital',
        96=>'Verpackungsindustrie',
        97=>'Versicherungen',
        98=>'Versorger',
    ],
    'W' => [
        99=>'Werbung / PR / Marketing',
    ],
    ''=> [
        0=>'Andere'
    ]
];

$sectorList = [
        'Andere',
        'Anlagen-/ Maschinenbau',
        'Automobile',
        'Automobilproduktion',
        'Automobilzulieferer',
        'Banken',
        'Bau-Zulieferer / Baustoffe',
        'Baudienstleister',
        'Bauhauptgewerbe',
        'Bekleidung / Textilien / Schuhe',
        'Bildung und Forschung',
        'Biotechnologie',
        'Brief- / Paketdienste',
        'Chemie',
        'Chiphersteller / Halbleiter',
        'Datenspeicherung',
        'Dienstleistungen',
        'E-Commerce-Software',
        'Einzelhandel',
        'Elektroausstattung',
        'Elektronische Bauelemente',
        'Elektrotechnologie',
        'Energie',
        'Erneuerbare Energien',
        'Finanzdienstleister',
        'Fluggesellschaften',
        'Gerätehersteller',
        'Gesundheitsdienstleister',
        'Getränke / Tabak',
        'Großhandel',
        'Gütertransport',
        'Handel',
        'Hardware',
        'Holdings / Mischkonzerne',
        'Holzindustrie / Holzverarbeitung',
        'Hotelgewerbe',
        'Immobilien',
        'Industrie',
        'Industriedienstleister',
        'Informationstechnologie',
        'Ingenieurdienstleister',
        'Internet-Dienstleister',
        'Internethandel (BB, BC)',
        'IT-Beratung',
        'IT-Dienstleister',
        'IT-Software',
        'Kaufhäuser',
        'Konsumgüter',
        'Kunststoffe',
        'Lichttechnik',
        'Logistik',
        'Luft- und Raumfahrt',
        'Luxusgüter',
        'Medien / Entertainment',
        'Medizinische Produkte / Medizintechnik',
        'Metallverarbeitung',
        'Möbel / Einrichtung',
        'Mobilkommunikation',
        'Nahrung / Restaurant',
        'Nanotechnologie',
        'Netzbetreiber',
        'Netzwerkaufbau / -ausrüster',
        'Netzwerktechnik',
        'Nutzfahrzeuge',
        'Ökoprodukte',
        'Öl / Gas',
        'Outsourcing',
        'Papier- / Kartonindustrie',
        'PCs',
        'Personaldienstleister',
        'Pharma',
        'Rechte',
        'Receycling',
        'Rohstoffe',
        'Rohstoffförderung',
        'Rückversicherungen',
        'Rüstungsindustrie',
        'Schiffbau',
        'Schifffahrt',
        'Server / Großrechner',
        'Software',
        'Softwareservice / -dienstleistungen',
        'Spezialchemie',
        'Sportartikel',
        'Stahl- / Metallindustrie',
        'Straßen / Schienen',
        'Supermärkte',
        'Telekommunikation',
        'Telekommunikationsausrüster',
        'Touristik',
        'Umwelt-Dienstleister',
        'Umweltschutztechnologie',
        'Unterhaltungselektronik',
        'Unternehmensberatung',
        'Unternehmensbeteiligungen',
        'Venture Capital',
        'Verpackungsindustrie',
        'Versicherungen',
        'Versorger',
        'Werbung / PR / Marketing',
];

$employeeAmount = array(
    "weniger als 10",
    "10 bis 100",
    "100 bis 1.000",
    "mehr als 1.000",
);