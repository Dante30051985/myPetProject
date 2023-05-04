<?php
include_once './php/db/checkedDb.php';


if(isset($_GET['code'])) {
  
  $params = array(  
    'client_id' => '**********',
    'client_secret' => '**********',
    'redirect_uri' => 'https://scn-ural.ru/vk.php',
    'code' => $_GET['code']
  );

  $data = file_get_contents('https://oauth.vk.com/access_token?' . urldecode(http_build_query($params)));
  $data = json_decode($data, true);


	if (isset($data['access_token'])) {
	
		$paramsNameFamPhoto = array(
			'v'            => '5.89',
			'uids'         => $data['user_id'],
			'access_token' => $data['access_token'],
			'fields'       => 'photo_big', 
		);
 
		$infoNameFamPhoto = file_get_contents('https://api.vk.com/method/users.get?' . urldecode(http_build_query($paramsNameFamPhoto)));
		$infoNameFamPhoto = json_decode($infoNameFamPhoto, true);	

		$paramsCountry = array(
			'v'            => '5.89',
			'uids'         => $data['user_id'],
			'access_token' => $data['access_token'],
			'fields'       => 'country', 
		);
 
		$infoCountry = file_get_contents('https://api.vk.com/method/users.get?' . urldecode(http_build_query($paramsCountry)));
		$infoCountry = json_decode($infoCountry, true);	

		$paramsCity = array(
			'v'            => '5.89',
			'uids'         => $data['user_id'],
			'access_token' => $data['access_token'],
			'fields'       => 'city', 
		);
 
		$infoCity = file_get_contents('https://api.vk.com/method/users.get?' . urldecode(http_build_query($paramsCity)));
		$infoCity = json_decode($infoCity, true);	

		$infoVK['id_vk'] = $infoNameFamPhoto['response']['0']['id'];
		$infoVK['photo'] = $infoNameFamPhoto['response']['0']['photo_big'];
		$infoVK['firstName'] = $infoNameFamPhoto['response']['0']['first_name'];
		$infoVK['lastName'] = $infoNameFamPhoto['response']['0']['last_name'];
		$infoVK['private'] = $infoNameFamPhoto['response']['0']['is_closed'];
		$infoVK['seeProfile'] = $infoNameFamPhoto['response']['0']['can_access_closed'];
		$infoVK['country'] = $infoCountry['response']['0']['country']['title'];
		$infoVK['city'] = $infoCity['response']['0']['city']['title'];


		$querySelectVKUser = $db->prepare('select * from `users_more` where `id_vk` = ?');
		$querySelectVKUser->bind_param('i', $infoVK['id_vk']);
		$querySelectVKUser->execute();
		$GetResultSelUser = $querySelectVKUser->get_result();
		$resultSelUser = $GetResultSelUser->num_rows;

		if ($resultSelUser > 0) {

			$querySelectUser = $db->prepare('SELECT users.id, users.login, users.email, users.password, 
			users_more.id_vk, users_more.photo_vk, users_more.first_name_vk, users_more.last_name_vk,
			users_more.country_vk, users_more.city_vk, users_more.private_profile_vk, 
			users_more.see_profile_vk
		   FROM users
		   INNER JOIN users_more ON users.id = users_more.id');

			$querySelectUser->execute();

			$getResultSelectUser = $querySelectUser->get_result();
			$resultSelectUser = $getResultSelectUser->fetch_array();

	
		} else {

			$nonameUser = 'аккаунт' . rand(1000, 100000);
				$sqlUser = $db->prepare("INSERT INTO `users` (`id`, `login`, `email`, 
				`password`) 
				VALUES (NULL, ?, '', '')");
				$sqlUser->bind_param('s', $nonameUser);
				$sqlUser->execute();
				$last_id = $sqlUser->insert_id;

				$sql = $db->prepare("INSERT INTO `users_more` (`id`, `id_user`, `id_vk`, `photo_vk`, `first_name_vk`, `last_name_vk`, 
				`country_vk`, `city_vk`, `private_profile_vk`, `see_profile_vk`) 
				VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$sql->bind_param('sssssssss',
								$last_id,
								$infoVK['id_vk'], 
								$infoVK['photo'], 
								$infoVK['firstName'], 
								$infoVK['lastName'],
								$infoVK['country'],
								$infoVK['city'],
								$infoVK['private'],
								$infoVK['seeProfile']);
				$sql->execute();
								

			

		}
	}
}



?>
