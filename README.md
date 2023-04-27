# test


### Docker - Project Setup Laravel

```sh
./vendor/bin/sail up
```

### Docker - Project Setup Vuejs

```sh
cd client
docker build -t client .
docker run -it -p 8080:80 --rm --name app client
```
