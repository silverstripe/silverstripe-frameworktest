<?php

class Company extends DataObject {

	/**
	 *
	 * @var array
	 */
	public static $db = array(
		'Name'=>'Varchar(255)',
		'Category'=>'Varchar(255)',
		'Revenue'=>'Float',
		'CEO'=>'Varchar(255)',
	);

	public static $has_one = array(
		'RelationFieldsTestPage' => 'RelationFieldsTestPage',
		'GridFieldTestPage' => 'GridFieldTestPage'
	);
	
	public static $has_many  = array(
		'Employees' => 'Employee'
	);

	static $belongs_many_many = array(
		'RelationFieldsTestPages' => 'RelationFieldsTestPage',
		'GridFieldTestPage' => 'GridFieldTestPage'
	);

	public static $summary_fields = array('Name', 'Category', 'Revenue', 'CEO');

	
	public function getCMSFields() {
		$fields = new FieldList();
		$fields->add(new TextField('Name', 'Name', $this->Name));
		$fields->add(new TextField('Category', 'Category', $this->Category));
		$fields->add(new TextField('Revenue', 'Revenue', $this->Revenue));
		$fields->add(new TextField('CEO', 'CEO', $this->CEO));
		
		$config = new GridFieldConfig();
		$config->addComponent(new GridFieldRelationAdd('Name'));
		$config->addComponent(new GridFieldDefaultColumns());
		$config->addComponent(new GridFieldSortableHeader());
		$config->addComponent(new GridFieldPaginator());
		$config->addComponent(new GridFieldAction_Edit());
		$config->addComponent(new GridFieldRelationDelete());
		$config->addComponent(new GridFieldPopupForms());
		
		$gridField = new GridField('Employees', 'Employees', $this->Employees(), $config);
		$fields->add($gridField);
		return $fields;
	}
	
	public function requireDefaultRecords() {
		parent::requireDefaultRecords();
		$companySet = DataObject::get('Company');
		foreach ($companySet as $company) {
			$company->delete();
		}
		
		foreach($this->data() as $companyData){
			$company = new Company();
			$company->Name = $companyData[0];
			$company->Category = $companyData[1];
			$company->Revenue = $companyData[2];
			$company->CEO = $companyData[3];
			$company->write();
		}
		DB::alteration_message("Added default records to Company table","created");
	}

	/**
	 * Contains test data
	 *
	 * @return array
	 */
	public function data() {
		return array(
			0 => array("Walmart", "Retail", "421.849", "Michael Duke"),
			1 => array("ExxonMobil", "Oil and gas", "370.125", "Rex W. Tillerson"),
			2 => array("Royal Dutch Shell", "Oil and gas", "368.056", "Peter Voser"),
			3 => array("BP", "Oil and gas", "297.107", "Robert Dudley"),
			4 => array("Sinopec", "Oil and gas", "289.774", "Jiming Wang"),
			5 => array("State Grid Corporation of China", "Electricity", "231.556", "Liu Zhenya"),
			6 => array("Toyota Motors", "Automotive", "228.247", "Fujio Cho"),
			7 => array("PetroChina", "Oil and gas", "221.955", "Zhou Jiping"),
			8 => array("Total S.A.", "Oil and gas", "212.815", "Christophe de Margerie"),
			9 => array("Japan Post Holdings", "Conglomerate", "211.080", "Jiro Saito"),
			10 => array("Chevron", "Oil and gas", "204.928", "David J. O'Reilly"),
			11 => array("ConocoPhillips", "Oil and gas", "198.655", "James Mulva"),
			12 => array("Vitol", "Raw material", "195.0", "Ian Taylor"),
			13 => array("Saudi Aramco", "Oil and gas", "182.396", "Waleed Al-Bedaiwi"),
			14 => array("Volkswagen Group", "Automotive", "169.53", "Martin Winterkorn"),
			15 => array("Fannie Mae", "Financial services", "154.270", "Mike Williams"),
			16 => array("General Electric", "Conglomerate", "150.211", "Jeffrey Immelt"),
			17 => array("Glencore", "Raw materials", "144.978", "Ivan Glasenberg"),
			18 => array("Allianz", "Financial services", "142.24", "Michael Diekmann"),
			19 => array("ING Group", "Financial services", "140.729", "Jan Hommen"),
			20 => array("Berkshire Hathaway", "Conglomerate", "136.185", "Warren Buffett"),
			21 => array("Samsung Electronics", "Conglomerate", "135.772", "Lee Kun-hee"),
			22 => array("General Motors", "Automotive", "135.592", "Daniel Akerson"),
			23 => array("Eni", "Oil and gas", "131.292", "Paolo Scaroni"),
			24 => array("Daimler AG", "Automotive", "130.628", "Dieter Zetsche"),
			25 => array("Ford Motor Company", "Automotive", "128.954", "Alan Mulally"),
			26 => array("Hewlett-Packard", "Information technology", "127.245", "Meg Whitman"),
			27 => array("Nippon Telegraph and Telephone", "Telecommunications", "124.517", "Norio Wada"),
			28 => array("AT&T", "Telecommunications", "124.28", "Randall L. Stephenson"),
			29 => array("E.ON", "Electricity; gas", "124.084", "Johannes Teyssen"),
			30 => array("Carrefour", "Retailing", "122.280", "Lars Olofsson"),
			31 => array("AXA", "Financial services", "121.577", "Henri de Castries"),
			32 => array("Assicurazioni Generali", "Insurance", "121.299", "Sergio Balbinot, Giovanni Perissinotto"),
			33 => array("Petrobras", "Oil and gas", "120.052", "José Sérgio Gabrielli de Azevedo"),
			34 => array("Cargill", "Agriculture", "119.469", "Greg Page"),
			35 => array("JX Holdings", "Energy", "116.414", "-"),
			36 => array("GDF Suez", "Public utilities", "112.88", "Gérard Mestrallet"),
			37 => array("Hitachi, Ltd.", "Conglomerate", "112.239", "Etsuhiko Shoyama"),
			38 => array("McKesson Corporation", "Health care", "112.084", "John Hammergren"),
			39 => array("Gazprom", "Oil and Gas", "111.808", "Alexei Miller"),
			40 => array("Bank of America", "Banking", "111.39", "Brian Moynihan"),
			41 => array("Tesco", "Retailing", "110.85", "Philip Clarke"),
			42 => array("Federal Home Loan Mortgage Corporation", "Financial services", "109.956", "Richard F. Syron"),
			43 => array("Apple Inc.", "Electronics", "108.249", "Tim Cook"),
			44 => array("Honda", "Automotive", "107.985", "Takanobu Ito"),
			45 => array("Verizon", "Telecommunications", "106.565", "Ivan Seidenberg"),
			46 => array("Nissan Motors", "Automotive", "105.523", "Carlos Ghosn"),
			47 => array("Panasonic Corporation", "Electronics", "105.035", "Kunio Nakamura"),
			48 => array("Nestlé", "Food processing", "104.972", "Paul Bulcke"),
			49 => array("LUKoil", "Oil and Gas", "104.956", "Vagit Alekperov"),
			50 => array("Pemex", "Oil and gas", "103.538", "Juan José Suárez Coppel"),
			51 => array("JPMorgan Chase", "Financial Services", "102.694", "Jamie Dimon"),
			52 => array("Cardinal Health", "Health care", "102.644", "George Barrett"),
			53 => array("Koch Industries", "Conglomerate", "100.0", "Charles Koch"),
			54 => array("Petróleos de Venezuela", "Oil and gas", "94.929", "Rafael Ramírez"),
			55 => array("IBM", "Information technology", "99.87", "Virginia Rometty"),
			56 => array("Siemens AG", "Conglomerate", "98.870", "Peter Löscher"),
			57 => array("Hyundai Motors", "Automotive", "98.858", "Chung Mong-Koo"),
			58 => array("Enel", "Electricity generation", "97.782", "Fulvio Conti"),
			59 => array("CVS Caremark", "Retailing", "96.413", "Tom Ryan"),
			60 => array("Lloyds Banking Group", "Financial Services", "95.342", "António Horta-Osório"),
			61 => array("UnitedHealth Group", "Health care", "94.155", "Stephen Hemsley"),
			62 => array("Statoil", "Oil and gas", "90.733", "Helge Lund"),
			63 => array("Metro AG", "Retailing", "89.87", "Eckhard Cordes"),
			64 => array("Aviva", "Financial services", "89.890", "Andrew Moss"),
			65 => array("Electricité de France", "Electricity generation", "87.073", "Henri Proglio"),
			66 => array("Costco", "Retailing", "87.048", "Jim Sinegal"),
			67 => array("Citigroup", "Financial services", "86.601", "Vikram Pandit"),
			68 => array("Sony", "Electronics", "86.521", "Howard Stringer"),
			69 => array("BASF", "Chemical industry", "85.347", "Kurt Bock"),
			70 => array("Wells Fargo", "Banking / Financial services", "85.21", "John Stumpf"),
			71 => array("Société Générale", "Financial Services", "84.868", "Frédéric Oudéa"),
			72 => array("Kuwait Petroleum Corporation", "Oil and gas", "84.594", "Saad Al Shuwaib"),
			73 => array("Deutsche Telekom", "Telecommunications", "83.407", "René Obermann"),
			74 => array("Procter & Gamble", "Consumer goods", "82.559", "Robert A. \"Bob\" McDonald"),
			75 => array("Industrial and Commercial Bank of China", "Banking", "82.536", "Jiang Jianqing"),
			76 => array("Valero Energy", "Oil and gas", "82.233", "Bill Klesse"),
			77 => array("Kroger", "Retailing", "82.189", "David Dillon"),
			78 => array("Nippon Life Insurance", "Insurance", "81.315", "Kunie Okamoto"),
			79 => array("Telefónica", "Telecommunications", "80.938", "César Alierta"),
			80 => array("BMW", "Automotive", "80.809", "Norbert Reithofer"),
			81 => array("Repsol YPF", "Oil and Gas", "80.747", "Antonio Brufau"),
			82 => array("Archer Daniels Midland", "Agriculture, Food processing", "80.676", "Patricia A. Woertz"),
			83 => array("AmerisourceBergen", "Health care", "80.218", "R. David Yost"),
			84 => array("HSBC", "Financial services", "80.014", "Stuart Gulliver"),
			85 => array("SK Group", "Conglomerate", "79.603", "Choi Tae-Won"),
			86 => array("National Iranian Oil Company", "Oil and gas", "79.277", "Masoud Mir Kazemi"),
			87 => array("Trafigura", "Raw materials", "79.2", " ?"),
			88 => array("ArcelorMittal", "Steel", "78.025", "Lakshmi Mittal"),
			89 => array("American International Group", "Financial services", "77.301", "Robert Benmosche"),
			90 => array("Toshiba", "Conglomerate", "77.090", "Tadashi Okamura"),
			91 => array("Petronas", "Oil and gas", "76.822", "Tan Sri Dato Sri Mohd Hassan Marican"),
			92 => array("Indian Oil Corporation", "Oil and Gas", "75.632", "B.M.Bansal"),
			93 => array("Fiat", "Conglomerate", "75.172", "Sergio Marchionne"),
			94 => array("ZEN-NOH", "Agricultural marketing", "75.111", "Katsuyoshi Kitajima"),
			95 => array("PSA Peugeot Citroën", "Automotive", "74.909", "Philippe Varin"),
			96 => array("Vodafone", "Telecommunications", "73.635", "Vittorio Colao"),
			97 => array("Marathon Oil", "Oil and gas", "73.621", "Clarence Cazalot, Jr."),
			98 => array("China Mobile", "Telecommunications", "73.520", "Li Yue"),
			99 => array("Prudential plc", "Banking", "73.337", "Tidjane Thiam"),
			100 => array("Walgreens", "Retailing", "72.184", "Jeff Rein"),
			101 => array("Deutsche Post", "Courier", "71.751", "Frank Appel"),
			102 => array("BHP Billiton", "Mining", "71.739", "Marius Kloppers"),
			103 => array("RWE", "Public utilities", "71.246", "Jürgen Großmann"),
			104 => array("Aegon", "Insurance", "71.148", "Alex Wynaendts"),
			105 => array("REWE Group", "Retailing", "70.872", "Alain Caparros"),
			106 => array("Dexia", "Banking", "70.106", "Pierre Mariani"),
			107 => array("Microsoft", "Information technology", "69.943", "Steve Ballmer"),
			108 => array("China Railway Construction Corporation", "Infrastructure", "69.118", "Meng Fengchao"),
			109 => array("China Railway Engineering Corporation", "Infrastructure", "69.082", "Shi Dahua"),
			110 => array("Toyota Tsusho", "Sogo shosha", "69.076", "Masaaki Furukawa"),
			111 => array("China Construction Bank", "Banking", "68.777", "Guo Shuqing"),
			112 => array("Home Depot, Inc.", "Retailing", "67.997", "Frank Blake"),
			113 => array("Zurich Financial Services", "Insurance", "67.85", "Martin Senn"),
			114 => array("Pfizer", "Health care", "67.809", "Jeff Kindler"),
			115 => array("Philip Morris International", "Tobacco industry", "67.713", "Louis C. Camilleri"),
			116 => array("Groupe BPCE", "Banking", "67.303", "François Pérol"),
			117 => array("Target Corporation", "Retailing", "67.390", "Gregg Steinhafel"),
			118 => array("Temasek Holdings", "Sovereign Wealth Fund", "66.285", "Suppiah Dhanabalan"),
			119 => array("Medco Health Solutions", "Health care", "65.968", "David B. Snow, Jr."),
			120 => array("United States Postal Service", "Courier", "65.711", "John E. Potter"),
			121 => array("Gunvor", "Raw material", "65.0", "-"),
			122 => array("Crédit Agricole", "Financial Services", "64.800", "Jean-Paul Chifflet"),
			123 => array("Tokyo Electric Power", "Electricity generation", "64.964", "Tsunehisa Katsumata"),
			124 => array("Boeing", "Aerospace", "64.306", "Jim McNerney"),
			125 => array("Barclays Bank", "Banking", "63.978", "Bob Diamond"),
			126 => array("State Farm Insurance", "Insurance", "63.2", "Edward B. Rust Jr."),
			127 => array("Bosch Group", "Automotive", "63.147", "-"),
			128 => array("PTT Public Company Limited", "Oil and Gas", "62.998", "Prasert Bunsumpun"),
			129 => array("Royal Bank of Scotland", "Financial services", "62.770", "Stephen Hester"),
			130 => array("Mitsubishi Corporation", "Sogo shosha", "62.733", "Mikio Sasaki"),
			131 => array("Seven & I Holdings Co.", "Retailing", "62.436", "Toshifumi Suzuki"),
			132 => array("ÆON", "Retailing", "62.153", "-"),
			133 => array("Agricultural Bank of China", "Banking", "62.151", "Xiang Junbo"),
			134 => array("Johnson & Johnson", "Health care", "61.587", "William C. Weldon"),
			135 => array("Dell", "Information technology", "61.494", "Michael Dell"),
			136 => array("EADS", "Aerospace", "60.969", "Louis Gallois"),
			137 => array("Munich Re", "Financial services", "60.851", "Nikolaus von Bomhard"),
			138 => array("France Télécom", "Telecommunications", "60.801", "Stéphane Richard"),
			139 => array("Rio Tinto", "Mining", "60.323", "Tom Albanese"),
			140 => array("CNP Assurances", "Insurance", "59.846", "Gilles Benoist"),
			141 => array("Reliance Industries", "Conglomerate", "59.679", "Mukesh Ambani"),
			142 => array("Legal & General", "Financial services", "59.673", "Tim Breedon"),
			143 => array("Bank of China", "Banking", "59.668", "Xiao Gang"),
			144 => array("Unilever", "Consumer goods", "59.143", "Paul Polman"),
			145 => array("WellPoint", "Health care", "58.802", "Angela Braly"),
			146 => array("BNP Paribas", "Financial Services", "58.632", "Baudouin Prot"),
			147 => array("China Life Insurance", "Insurance", "58.460", "-"),
			148 => array("Edeka Group", "Retailing", "57.968", "-"),
			149 => array("PepsiCo", "Food", "57.838", "Indra Nooyi"),
			150 => array("Grupo Santander", "Banking", "57.388", "Emilio Botín"),
			151 => array("Auchan", "Retailing", "56.778", "Christophe Dubrulle"),
			152 => array("Noble Group", "Raw materials", "56.696", "Ricardo Leiman"),
			153 => array("China State Construction Engineering Corp", "Infrastructure", "56.104", "Sun Wenjie"),
			154 => array("Banco Bradesco", "Banking", "56.104", "Luiz Carlos Trabuco Cappi"),
			155 => array("A. P. Møller - Mærsk", "Transport", "56.090", "Nils Andersen"),
			156 => array("Dongfeng Motor", "Automotive", "55.864", "Xu Ping"),
			157 => array("China Southern Power Grid Company", "Electricity", "55.825", "Yuan Maozhen"),
			158 => array("Deutsche Bank", "Banking", "55.804", "Josef Ackermann"),
			159 => array("Shanghai Automotive Industry Corporation", "Automotive", "55.689", "Shen Jianhua"),
			160 => array("Fujitsu", "Electronics", "54.559", "Hiroaki Kurokawa"),
			161 => array("United Technologies", "Conglomerate", "54.326", "Louis R. Chênevert"),
			162 => array("Credit Suisse", "Financial services", "53.771", "Brady Dougan"),
			163 => array("China National Offshore Oil Corporation", "Oil and gas", "53.733", "Wang Yilin"),
			164 => array("Dow Chemical", "Manufacturing", "53.674", "Andrew N. Liveris"),
			165 => array("Saint-Gobain", "Construction", "53.607", "Pierre-André de Chalendar"),
			166 => array("UniCredit", "Banking", "53.332", "Federico Ghizzoni"),
			167 => array("Nokia", "Telecommunications", "53.322", "Stephen Elop"),
			168 => array("MetLife", "Insurance", "52.717", "C. Robert Henrikson"),
			169 => array("Renault", "Automotive", "52.073", "Carlos Ghosn"),
			170 => array("Mitsubishi UFJ Financial Group", "Banking", "51.479", "Nobuo Kuroyanagi"),
			171 => array("ThyssenKrupp", "Conglomerate", "50.717", "Heinrich Hiesinger"),
			172 => array("Sinochem Group", "Conglomerate", "50.632", "Liu Deschu"),
			173 => array("Hoffmann-La Roche", "Health care", "50.632", "Severin Schwan"),
			174 => array("Novartis", "Health care", "50.624", "Joseph Jimenez"),
			175 => array("Best Buy", "Retailing", "50.272", "Brian J. Dunn"),
			176 => array("United Parcel Service", "Transportation", "49.545", "Scott Davis"),
			177 => array("Pertamina", "Oil and gas", "48.717", "Karen Agustiawan"),
			178 => array("Dai-ichi Life", "Insurance", "47.855", "-"),
			179 => array("Banco Bilbao Vizcaya Argentaria", "Banking", "47.429", "Francisco González"),
			180 => array("Lowe's", "Retailing", "47.22", "Robert Niblock"),
			181 => array("Rosneft", "Oil and gas", "46.826", "-"),
			182 => array("National Mutual Insurance Federation of Agricultural Cooperatives (Zenkyoren or JA Kyosai)", "Insurance", "46.8", "-"),
			183 => array("VINCI", "Construction", "46.762", "Xavier Huillard"),
			184 => array("Veolia Environnement", "Public utilities", "46.482", "Antoine Frérot"),
			185 => array("Vale", "Mining", "46.481", "Murilo Ferreira"),
			186 => array("Woori Financial Group", "Financial services", "46.459", "Lee Pal Seung"),
			187 => array("Sonatrach", "Oil and gas", "46.420", "Djenane El Malik"),
			188 => array("GlaxoSmithKline", "Health care", "46.016", "Andrew Witty"),
			189 => array("Deutsche Bahn", "Transportation", "45.979", "Rüdiger Grube"),
			190 => array("Goldman Sachs", "Financial services", "45.976", "Lloyd Blankfein"),
			191 => array("Hon Hai Precision Industry", "Electronics", "45.899", "Terry Gou"),
			192 => array("Lockheed Martin", "Aerospace", "45.803", "Robert J. Stevens"),
			193 => array("Woolworths Limited", "Retailing", "45.170", "Michael Luscombe"),
			194 => array("Bouygues", "Conglomerate", "45.167", "Martin Bouygues"),
			195 => array("Bayer", "Health care", "44.901", "Marijn Dekkers"),
			196 => array("China Investment Corporation", "Sovereign wealth fund", "44.876", "Lou Jiwei"),
			197 => array("Imperial Tobacco", "Tobacco industry", "44.713", "Gareth Davis"),
			198 => array("Mitsui & Co.", "Sogo shosha", "44.048", "-"),
			199 => array("Sears Holdings", "Retailing", "44.043", "Louis D'Ambrosio"),
			200 => array("LG Electronics", "Conglomerate", "44.000", "Koo Bon-joon"),
			201 => array("Shinhan Financial Group", "Financial services", "43.975", "Sang Hoon Shin"),
			202 => array("Wesfarmers", "Retailing", "43.949", "Bob Every"),
			203 => array("Intel", "Semiconductors", "43.623", "Paul S. Otellini"),
			204 => array("Sumitomo Life Insurance", "Insurance", "43.272", "-"),
			205 => array("Caterpillar", "Heavy equipment", "42.588", "Douglas R. Oberhelman"),
			206 => array("Sanofi", "Health care", "42.218", "Chris Viehbacher"),
			207 => array("Chrysler", "Automotive", "41.946", "Sergio Marchionne"),
			208 => array("Bunge Limited", "Agriculture", "41.926", "Alberto Weisser"),
			209 => array("Sojitz", "Sogo shosha", "41.338", "Yutaka Kase"),
			210 => array("Safeway", "Retailing", "40.8507", "Steven Burd"),
			211 => array("SuperValu", "Retailing", "40.597", "Craig Herkert"),
			212 => array("UBS", "Financial services", "40.561", "Oswald Grübel"),
			213 => array("Kraft Foods", "Food", "40.386", "Irene Rosenfeld"),
			214 => array("Ahold", "Retailing", "40.229", "Dick Boer"),
			215 => array("Cisco", "Information technology", "40.04", "John T. Chambers"),
		);
	}
}
