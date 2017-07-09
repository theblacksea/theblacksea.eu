var contextElems={
	iniTitle1: 'From Slovakia to the Paris attacks',
	iniTitle2: 'the Weapons Route',
	iniTextSmart: 'A lack of arms control in Slovakia has allowed weapons to be exported or trafficked to countries in and out of Europe - and is connected to the Paris terrorist attacks in January 2015. <br/> While new Slovakian legislation is moving towards restricting the sale of blank firing arms that can be converted into active weapons, serious problems remain.',
	iniText: 'A lack of arms control in Slovakia has allowed weapons to be exported or trafficked to countries in and out of Europe - and is connected to the Paris terrorist attacks in January 2015. <br/> While new Slovakian legislation is moving towards restricting the sale of blank firing arms that can be converted into active weapons, serious problems remain. <span id="goPoints" onclick="javascript:goToPoint(0);">Start the route.</span>',
	fullWeaponTxt: 'Click here to see the weapon'
};

var weaponInfoTxts={
	model: 'Model',
	snumber: 'Serial number',
	capacity: 'Capacity',
	large: 'Total length'
};

var pointsData=[

	// 0
	{
		title: 'AFG Security-Company',
		city: 'Partizanske',
		country:'Slovakia',
		coords: [48.625298, 18.355740],
		attempt: false,
		text: 'This is the starting point of the Paris terror attacks in January, 2015. Through its website, Slovak company AFG Security sells <i>deactivated<i/> guns.'
	},

	// 1
	{	
		title: 'Halluent, the weapons collector',
		city:'Marcinelle',
		country:'Belgium',
		coords: [50.400422, 4.433044],
		attempt: false,
		text:'Patrick Halluent is a Belgian engineer and weapons collector living in Marcinelle. Between June 2013 and May 2014 he buys 174 weapons from AFG Security. Among them, on January 13th, 2014, he buys an assault rifle CZ VZ58.'
	},

	// 2
	{
		title: 'Hermant, the paintball promoter ',
		city: 'Ennetières-en-Weppes',
		country: 'France',
		coords: [50.602426, 2.993254],
		attempt: false,
		text: 'Former French paramilitary and extreme-right activist Claude Hermant manages a paintball club in the commune of Ennetières-en Weppes, ten kilometers away from Lille. A police informant, Hermant tells the French services about Patrick Halluent - and aims to ask the Belgian for weapons in a supposed <i>infiltration mission<i/>.'
	},
	
	// 3
	{
		title: 'Car park of Makro supermarket ',
		city: 'Lodelinsart',
		country: 'Belgium',
		coords: [50.428242, 4.437119],
		attempt: false,
		text: 'Patrick Halluent delivers weapons to Claude Hermant at the car park of Makro supermarket in Lodelinsart and a McDonald´s in Charleroi.'
	},
	
	// 4
	{
		title: 'Seth Outdoor company',
		city: 'Haubourdin',
		country: 'France',
		coords: [50.609486, 2.985849],
		attempt: false,
		text: 'Halluent is arrested by the police in May 2014. Afterwards, Hermant buys weapons from Slovak AFG Security through Seth Outdoor, a French company that sells paintball material by mail and where he has an accomplice. Between September and November 2014, Seth Outdoor buys from AFG Security´s website at least 23 guns of the brand Ceska VZ58 (Czechoslovakian assault rifle), 16 of Tokarev TT33 (Soviet semiautomatic pistol) and an unidentified number of Scorpion VZ61 (Czechoslovakian automatic rifle).'
	},
	
	// 5
	{
		title: 'Police station ',
		city: 'Villeneuve d’Ascq',
		country: 'France',
		coords: [50.646116, 3.130463],
		attempt: false,
		text: 'Hermant´s version is that he informed his contact in the research department of Villeneuve d´Ascq police station about an interesting target, known as Samir. L, who is linked to organized crime who was looking for heavy weapons. In Hermant´s statement, he claims that police officers gave him the green light to go ahead with the job.'
	},
	
	
	// 6 
	{
		title: 'Clandestine repair shop ',
		city: 'Lomme' ,
		country: 'France',
		coords: [50.646701, 2.985868],
		attempt: false,
		text: 'Hermant receives the weapons from AFG Security by mail. In his workshop, the police find weapons, ammunition and tools that allow him to reactivate small arms (Tokarev TT33 and Skorpion). According to the experts, the Ceskas would have been reactivated elsewhere, using more sophisticated material. '
	},
	
	// 7
	{
		title: 'Car park of Decathlon',
		city: 'Villeneuve d’Ascq',
		country: 'France',
		coords: [50.616192, 3.127778],
		attempt: false,
		text: 'According to Hermant’s statement, he sold deactivated rifles and active pistols to Samir L.. The delivery took place in the car park of sports goods retailer Decathlon. The price of the weapons was between 600 or 800 Euro each.'
	},
	
	// 8
	{
		title: 'Jogger shot dead',
		city: 'Fontenay-aux-Roses',
		country: 'France',
		coords: [48.785856, 2.289667],
		attempt: true,
		text: '<span class="date">January 7th 2015</span>. The Islamist terrorist Ahmed Coulibaly uses one of the Tokarev pistols sold by Claude Hermant to shoot a jogger in a village about 10 kilometers away from Paris.',
		weapon: {
			model: 'Tokarev TT33 (URSS), 1951',
			snumber: 'PK507',
			capacity: 'eight cartridges (calibre 7,62 x 25 Toula-Tokarev)',
			large: '19.5 cm',
			img_id: 'tokarev_fontenay'
		}
	},
	
	// 9
	{
		title: 'Policewoman killed',
		city: 'Montrouge',
		country: 'France',
		coords: [48.816361, 2.316399],
		attempt: true,
		text: '<span class="date">January 8th</span>. Coulibaly uses again one of the arms from Slovakia to kill a police officer in a village about six kilometers away from Paris.'
	},
	
	// 10
	{
		title: 'Hypercacher in Porte de Vincennes',
		city: 'Paris',
		country: 'France',
		coords: [48.847027, 2.416022],
		attempt: true,
		text: '<span class="date">January 9th</span>. Coulibaly attacks kosher store Hypercacher in Porte de Vincennes, Paris, and murders four Jewish hostages. The terrorist is killed by the police - and three weapons are found next to his body: two Tokarev TT33 and one CZ VZ58 Subcompact. The Subcompact has been used to shoot and kill Yohan Cohen, a 20-year-old shop-assistant at the Hypercacher. The assault rifle CZ VZ58 that Halluent bought from AFG Security is also found that day at the Hypercacher.',
		weapon: {
			model: 'Ceska Zbrojovka VZ-58 Subcompact (Czech Republic), 1964',
			snumber: '63622t ou 63822t (un impact de balle empêche la lecture)',
			capacity: '30 cartridges (calibre 7,62 x 39)',
			large: '44.5 cm',
			img_id: 'ceska_hypercacher'
		},
		weapon2: {
			model: 'Tokarev TT33 (URSS), 1952',
			snumber: 'ОГ2027',
			capacity: 'eight cartridges (calibre 7,62 x 25 Toula-Tokarev)',
			large: '19.5 cm',
			img_id: 'tokarev_hypercacher'
		},
		weapon3:{
			model: 'Ceska Zbrojovka (Czechoslovakia), 1961',
			snumber: '21038m',
			capacity: '30 cartridges (calibre 7,62 x 39 Kalashnikov)',
			large: '54.2 cm',
			img_id: 'hypercacher_haullent'
		}
	},
	
	// 11
	{
		title: 'Le domicile de Coulibaly',
		city:'Gentilly',
		country:'France',
		coords: [48.814273, 2.338665],
		attempt: false,
		text:'Two other Tokarev guns bought from AFG Security are found at Coulibaly’s apartment, in a village on the outskirts of Paris.',
		weapon: {
			model: 'Tokarev TT33 (URSS), 1952',
			snumber: 'TE1035',
			capacity: 'eight cartridges (calibre 7,62 x 25 Toula-Tokarev)',
			large: '19.5 cm',
			img_id: 'tokarev_gentilly'
		}
	}
	
	/*
	// num
	{
		title: '',
		city: '',
		country: '',
		coords: [],
		attempt: false,
		text: ''
	},
	*/
];
