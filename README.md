#pokemon_go

#install dotenv package
#npm install dotenv

#if in case you cannot login due to sanctum restriction, please add your domain at sanctum.php file
#'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf('%s%s', 'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1, YOUR_DOMAIN OR YOUR_DOMAIN_WITH_PORT_NUMBER' Sanctum::currentApplicationUrlWithPort()))), 