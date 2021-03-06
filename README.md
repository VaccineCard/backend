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

- (Prefixo) patients {
	- (GET) {id?}
	- (Prefixo) family {
		- (GET) /{id?}
		- (POST) add
		- (POST) confirm
	}
}


- (Prefixo) doctors {
    - (GET) {id?}
    - (POST) addnewpacient
    - (DELETE) removepatient

    -(Prefix) admin {
		- (POST) register
        - (POST) registervaccine
    }
}


- (Prefixo) centers {
    - (GET) {id?}
    - (POST) add
    - (DELETE) remove/{id?}

      - (Prefixo) doctor {
        -(POST) confirm
		- (DELETE) remove/{id?}
    }
}

- (Prefixo) vaccines {
    - (GET) {id?}
    - (POST) add
    - (DELETE) remove
}


```

### ( Em desenvolvimento ainda )

```
- (Prefixo) auth {
	- (GET) confirm/{code}
}

- (Prefixo) doctors {

    -(Prefix) admin {
        - (PUT) update/{id}
    }
}

```
