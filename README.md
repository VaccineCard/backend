# Vaccine Card ( Backend )
Registrar individualmente dados de vacinação de todos os residentes em um determinado país.

## Usando API
A API está hospedada no Heroku, segui o link para uso dos endpoinrs da API. (Para Testes ).

	https://vaccine-card.herokuapp.com
	
## Contribuindo
### Comandos de instação

	$ composer install

Crie um arquivo `.env` baseado no arquivo `.env.example`.
	
	$ php artisan key:generate

Defina a conexão com o `SGBD` ( recomendamos ou o `mysql` ou o `pgsql` ).

	$ php artisan migrate
	$ php artisan db:seed
	
O `db:seed` gera dados na BD com os países e estados do mundo.
	
### Stack
 - PHP 7.2
 - Laravel 5.7
 
#### Dependecies
- JWT ( Tymon )

## Rotas

### Funcionando
```
- (Prefixo) auth {
	- (POST) signin ( Retorna um token e o usuário, caso o login esteja correcto )
	- (POST) signup
}

- (Prefixo)location {
    -(Prefixo) countries {
        - (GET) all
        - (GET) {id?}
        - (GET) {id?}/states
        - (GET) states/{id?}
    }
}

```

### Todas Rotas ( Em desenvolvimento ainda )

```
- (Prefixo) auth {
	- (POST) signin ( Retorna um token e o usuário, caso o login esteja correcto )
	- (POST) signup
	- (GET) confirm/{code}
}

- (Prefixo) user {
	- (GET) {id}
	- (Prefixo) family {
		- (GET) members
		- (POST) add
		- (POST) confirm
	}
}

- (Prefixo)location {
    -(Prefixo) countries {
        - (GET) all
        - (GET) {id?}
        - (GET) {id?}/states
        - (GET) states/{id?}
    }
}

```