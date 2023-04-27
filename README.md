# test


### Docker - Project Setup Laravel

```sh
cd api
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
sail up -d
```

### Docker - Project Setup Vuejs

```sh
cd client
docker build -t client .
docker run -it -p 8080:80 --rm --name app client
```
