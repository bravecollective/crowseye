<?
	##
	# this whole file is unrelated to the actual WH tracker, and just happens to be on the same website for convienience
	function dojoparser () {
		$pageTitle = "Dojo Audit";

		if ($hasBooks = isset($_POST['books'])) {

			$list = explode("\n", $_POST['books']);
	
			$books = array();
	
			foreach ($list as $book) {
				$book = explode("\t", str_replace(".", "", $book));
				if (!isset($books[$book[0]])) {
					$books[$book[0]] = $book[1];
				} else {
					$books[$book[0]] += $book[1];
				}
			}
	
			$outOfStock = "";
			$warning = "";
			$good = "";
	
			foreach (getAvailBooks() as $book) {
				if (!isset($books[$book])) $books[$book] = 0;
	
				$line = '<tr> <td>'.$book.'</td> <td>'.$books[$book].'</td> </tr>';
				if ($books[$book] == 0) {
					$outOfStock .= $line;
				} else if ($books[$book] < 5) {
					$warning .= $line;
				} else {
					$good .= $line;
				}
			}
		}
		include('templates/dojo.html');
	}


	function getAvailBooks() {
		return array(
			"Acceleration Control",
			"Advanced Planetology",
			"Advanced Target Management",
			"Advanced Weapon Upgrades",
			"Afterburner",
			"Amarr Battlecruiser",
			"Amarr Cruiser",
			"Amarr Destroyer",
			"Amarr Drone Specialization",
			"Amarr Encryption Methods",
			"Amarr Frigate",
			"Amarr Industrial",
			"Anchoring",
			"Archaeology",
			"Armor Layering",
			"Armor Resistance Phasing",
			"Armor Rigging",
			"Armored Warfare Specialist",
			"Assault Frigates",
			"Astrogeology",
			"Astrometric Acquisition",
			"Astrometric Pinpointing",
			"Astrometric Rangefinding",
			"Astrometrics",
			"Astronautics Rigging",
			"Auto-Targeting Missiles",
			"Biology",
			"Broker Relations",
			"Caldari Battlecruiser",
			"Caldari Cruiser",
			"Caldari Destroyer",
			"Caldari Drone Specialization",
			"Caldari Encryption Methods",
			"Caldari Frigate",
			"Caldari Industrial",
			"Capacitor Emission Systems",
			"Capacitor Management",
			"Capacitor Systems Operation",
			"Cloaking",
			"Combat Drone Operation",
			"Command Center Upgrades",
			"Connections",
			"Contracting",
			"Controlled Bursts",
			"Corporation Contracting",
			"Covert Ops",
			"CPU Management",
			"Criminal Connections",
			"Cruise Missiles",
			"Cybernetics",
			"Cynosural Field Theory",
			"Dark Ochre Processing",
			"Deep Core Mining",
			"Defender Missiles",
			"Diplomacy",
			"Drone Durability",
			"Drone Interfacing",
			"Drone Navigation",
			"Drone Sharpshooting",
			"Drones",
			"Drones Rigging",
			"Electronic Attack Ships",
			"Electronic Superiority Rigging",
			"Electronic Warfare",
			"Electronic Warfare Drone Interfacing",
			"Electronics Upgrades",
			"EM Armor Compensation",
			"EM Shield Compensation",
			"Energy Grid Upgrades",
			"Energy Pulse Weapons",
			"Energy Weapon Rigging",
			"Evasive Maneuvering",
			"Explosive Armor Compensation",
			"Explosive Shield Compensation",
			"Fast Talk",
			"Frequency Modulation",
			"Fuel Conservation",
			"Gallente Battlecruiser",
			"Gallente Cruiser",
			"Gallente Destroyer",
			"Gallente Drone Specialization",
			"Gallente Encryption Methods",
			"Gallente Frigate",
			"Gallente Industrial",
			"Gneiss Processing",
			"Gravimetric Sensor Compensation",
			"Guided Missile Precision",
			"Gunnery",
			"Hacking",
			"Heavy Assault Missiles",
			"Heavy Drone Operation",
			"Heavy Missiles",
			"Hedbergite Processing",
			"Hemorphite Processing",
			"High Speed Maneuvering",
			"Hull Upgrades",
			"Hybrid Weapon Rigging",
			"Ice Harvesting",
			"Ice Processing",
			"Industry",
			"Infomorph Psychology",
			"Information Warfare Specialist",
			"Interceptors",
			"Interplanetary Consolidation",
			"Jaspet Processing",
			"Jury Rigging",
			"Kernite Processing",
			"Kinetic Armor Compensation",
			"Kinetic Shield Compensation",
			"Laboratory Operation",
			"Ladar Sensor Compensation",
			"Large Artillery Specialization",
			"Large Blaster Specialization",
			"Large Energy Turret",
			"Launcher Rigging",
			"Leadership",
			"Light Missiles",
			"Long Distance Jamming",
			"Long Range Targeting",
			"Magnetometric Sensor Compensation",
			"Marketing",
			"Mass Production",
			"Material Efficiency",
			"Mechanics",
			"Medium Artillery Specialization",
			"Medium Beam Laser Specialization",
			"Medium Blaster Specialization",
			"Medium Energy Turret",
			"Medium Hybrid Turret",
			"Medium Projectile Turret",
			"Medium Pulse Laser Specialization",
			"Mercoxit Processing",
			"Mining",
			"Mining Director",
			"Mining Drone Operation",
			"Mining Foreman",
			"Mining Frigate",
			"Mining Upgrades",
			"Minmatar Cruiser",
			"Minmatar Destroyer",
			"Minmatar Drone Specialization",
			"Minmatar Encryption Methods",
			"Minmatar Frigate",
			"Minmatar Industrial",
			"Missile Bombardment",
			"Missile Launcher Operation",
			"Missile Projection",
			"Motion Prediction",
			"Nanite Operation",
			"Navigation",
			"Negotiation",
			"Omber Processing",
			"ORE Industrial",
			"Plagioclase Processing",
			"Planetology",
			"Power Grid Management",
			"Procurement",
			"Projectile Weapon Rigging",
			"Propulsion Jamming",
			"Pyroxeres Processing",
			"Radar Sensor Compensation",
			"Rapid Firing",
			"Rapid Launch",
			"Refinery Efficiency",
			"Refining",
			"Remote Armor Repair Systems",
			"Remote Hull Repair Systems",
			"Remote Sensing",
			"Repair Drone Operation",
			"Repair Systems",
			"Research",
			"Retail",
			"Rocket Specialization",
			"Light Missile Specialization",
			"Rockets",
			"Salvage Drone Operation",
			"Salvaging",
			"Science",
			"Scordite Processing",
			"Scout Drone Operation",
			"Scrapmetal Processing",
			"Sensor Linking",
			"Sentry Drone Interfacing",
			"Sharpshooter",
			"Shield Compensation",
			"Shield Emission Systems",
			"Shield Management",
			"Shield Operation",
			"Shield Rigging",
			"Shield Upgrades",
			"Signal Dispersion",
			"Signature Analysis",
			"Signature Focusing",
			"Skirmish Warfare",
			"Small Artillery Specialization",
			"Small Autocannon Specialization",
			"Small Pulse Laser Specialization",
			"Small Beam Laser Specialization",
			"Small Railgun Specialization",
			"Small Blaster Specialization",
			"Small Energy Turret",
			"Small Hybrid Turret",
			"Small Projectile Turret",
			"Social",
			"Spaceship Command",
			"Spodumain Processing",
			"Surgical Strike",
			"Survey",
			"Tactical Shield Manipulation",
			"Target Breaker Amplification",
			"Target Management",
			"Target Navigation Prediction",
			"Target Painting",
			"Thermic Armor Compensation",
			"Thermic Shield Compensation",
			"Thermodynamics",
			"Torpedoes",
			"Trade",
			"Trajectory Analysis",
			"Veldspar Processing",
			"Warp Drive Operation",
			"Weapon Disruption",
			"Weapon Upgrades",
			"Bomb Deployment",

		);
	}
?>