	$community_array = array("97", "El Naranjo", "Nueva Vida", "Pampojila", "Panimaquip", "Porvenir", "Providencia", "Quixaya", "San Andres", "San Felipe", "San Gabriel", "San Gregorio", "San Jose", "San Juan", "San Martin", "Santa Teresita", "Tierra Santa", "Totolya", "Xejuyu");

	$male_name_array = array("Santiago", "Matías", "Mateo", "Alejandro", "Samuel", "Diego", "Daniel", "Benjamin", "Tomás", "Gabriel", "Lucas", "David", "Juan", "Jose", "Andrés", "Adrián", "Emmanuel", "Felipe", "Pablo", "Andrés", "Ángel", "Rodrigo", "Miguel", "Fernando", "Conrado", "Javier", "Rafael", "Esteban", "Francisco", "Carlos", "Vicente", "Jorge", "Lorenzo", "Pedro", "Antonio", "Luis", "Eduardo", "Ricardo", "Estuardo", "Rogelio", "Mario", "Jaime", "Renato");

	$female_name_array = array("Emilse", "Maria", "Francisca", "Florinda", "Olivia", "Hilda", "Karina", "Clara", "Silvia", "Sandra", "Angelica", "Pamela", "Fatima", "Belén", "Ixchel", "Cesia", "Dominga", "Olga", "Petrona", "Rosa", "Graciela", "Gabriela", "Diana", "Andrea", "Julieta", "Anna", "Laura", "Carla", "Carolina", "Alicia", "Leticia", "Magdalena", "Amalia", "Alejandra", "Irma", "Ingrid", "Domitilia", "Juana", "Victoria", "Martina", "Sofia", "Jazmín", "Alma", "Claudia");

	$last_name_array = array("Chavez", "Herrera", "Navarro", "Morales", "Yoxon", "Julajuj", "Mejia", "Mazat", "Garcia", "Hernandez", "Lopez", "Ajcalon", "Pic", "Perez", "Gonzalez", "Sanchez", "Torres", "Rivera", "Gomez", "Diaz", "Reyez", "Cruz", "Urizar", "Tun", "Choguaj", "Mendoza", "Romero", "Aguilar", "Mendez", "Rios", "Soto", "Acosta", "Campos", "Molina", "Avila", "Santos", "Solis", "Fuentes", "Leon", "Calderon", "Macias", "Rosales", "Lec");

	
	for ($i = 0; $i < 200; $i++) {
		$community_id = rand(1,count($community_array));
		$sex = rand(1,2);
		$name = "";
		if ($sex == SEX_MALE) {
			$name = generateRandomMaleName();
		} else {
			$name = generateRandomFemaleName();
		}
		$date_of_birth = generateRandomDateOfBirth();
		$exact_date_of_birth_known = rand(1,2);
		$datetime_registered = "2017-04-30 03:27:56";

		$db->createPatient(true, $community_id, $name, $sex, $date_of_birth, $exact_date_of_birth_known, $datetime_registered);

		
	}

	function generateRandomDateOfBirth() {
		$year = rand(1930, 2015);
		$month = rand(1, 12);
		$day = rand(1,28);

		if ($month < 10) {
			$month = "0" . $month;
		}

		if ($day < 10) {
			$day = "0" . $day;
		}

		return $year . "-" . $month . "-" . $day;
	}


	function generateRandomMaleName() {
		global $male_name_array, $last_name_array;
		$first_name = $male_name_array[rand(0, count($male_name_array) - 1)];
		$last_name = $last_name_array[rand(0, count($last_name_array) - 1)];

		return $first_name . " " . $last_name;
	}

	function generateRandomFemaleName() {
		global $female_name_array, $last_name_array;
		$first_name = $female_name_array[rand(0, count($female_name_array) - 1)];
		$last_name = $last_name_array[rand(0, count($last_name_array) - 1)];

		return $first_name . " " . $last_name;
	}
	