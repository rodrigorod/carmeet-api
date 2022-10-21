# 🚀 Lando Symfony Boilerplate 🎼

# 📋 Requirements

---

- [Docker](http://docker.com)
- [Lando](http://lando.dev)

# Run the app
```sh
lando start
```

---

## Coding standards / Unit tests

**Run tests**

```sh
lando composer tests
```

**Fix coding standards automatically**
```sh
lando composer standards-fix
```

**Running each test separately**
```sh
lando composer test-phpcpd
lando composer test-phpmd
lando composer test-phpstan
lando composer test-phpunit
lando composer test-twig
```
