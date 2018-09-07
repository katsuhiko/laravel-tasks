## 環境構築 - 参考

- Laradock A.2) Don’t have a PHP project yet
    - http://laradock.io/getting-started/#A2
- Laradockを使ってLaravel 5.5環境を構築する
    - https://qiita.com/rock619/items/62c2ab2252c405e26479
- Laravel5.6チュートリアル 基本のタスクリスト
    - https://qiita.com/dyoshikawa/items/4b59c9594c72eb2321ea
- LaradockでLaravelのクイックスタートをやってみた <- 参考
    - https://qiita.com/katoosky/items/ed920df211945d84f7da
- LaradockでMySQLが起動しない問題への対処
    - https://blog.84b9cb.info/posts/mysql-error-laradock/
- nginxinc/docker-nginx - ログを標準出力へ
    - https://github.com/nginxinc/docker-nginx/blob/master/stable/alpine/Dockerfile#L135

------

## Docker Build & ECR

- ECSのチュートリアル - コンテナ運用を現実のものにする
    - https://qiita.com/niisan-tokyo/items/4e72c6c11c3f9562fe66
- Dockerfile から上の階層のディレクトリを参照する
    - https://qiita.com/TKR/items/ac29ee783bc4684d0612
- Dockerでlaravelの本番環境構築をしてみた (php-pfm,nginx, mysql, redis)
    - https://qiita.com/mytv1/items/9c2f558dcd7b0c92e6b3
- Laravelで標準出力にエラーログを出力する
    - http://kayakuguri.github.io/blog/2017/06/16/larave-std-error/
- Dockert調査　~ログ編~
    - https://qiita.com/HommaHomma/items/f943fa3397bc3f386057
- AWS Fargateでコンテナ間通信させたいとき
    - https://qiita.com/taishin/items/84122ad85bedf8b8a682

ローカルで動作確認する場合、 docker/server/nginx/default.conf の fastcgi_pass を 127.0.0.1 から app へ変更する。

```
docker exec -it laravel-tasks_app_1 php artisan migrate

docker build -t dev/web -f ./docker/server/nginx/Dockerfile .
docker build -t dev/app -f ./docker/server/php-fpm/Dockerfile .

docker-compose up -d db
docker run -d --name app --link laravel-tasks_db_1:db --net laravel-tasks_backend dev/app
docker run -d --name web --link app:app --net laravel-tasks_backend -p 80:80 dev/web

docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
```

```
$(aws ecr get-login --no-include-email --region ap-northeast-1)

docker tag dev/web:latest 999999999999.dkr.ecr.ap-northeast-1.amazonaws.com/dev/web:latest
docker push 999999999999.dkr.ecr.ap-northeast-1.amazonaws.com/dev/web:latest

docker tag dev/app:latest 999999999999.dkr.ecr.ap-northeast-1.amazonaws.com/dev/app:latest
docker push 999999999999.dkr.ecr.ap-northeast-1.amazonaws.com/dev/app:latest
```

------

## AWS ECS Fargate を使う

- AWSのコンテナサービスECSをALBで分散処理する on Fargate
    - https://qiita.com/IgnorantCoder/items/d4f16b1aadd1c03c0e26
    
上記に従えば、 Fargate を利用した環境を構築することができる。

使わないときに料金を極力発生させない方法（停止方法！？）

- ECS : クラスター > タブ.サービス - サービス名 > ボタン.更新 : タスク数を "0" へ更新する。
- ECS : クラスター > タブ.タスク - タスク名.check > ボタン.停止
- EC2 : ロードバランサー - ロードバランサー名.check > アクション.削除

再開方法

- EC2 : ロードバランサー : ALBの作成(手順は、上記のQiita記事)
- ECS : クラスター > タブ.サービス - サービス名 > ボタン.更新 : タスク数を "1" へ更新する。

------

## CI CodePipeline

- LaravelアプリケーションをCodePipeline/CodeBuildでECSに自動デプロイする
    - https://qiita.com/imunew/items/687221e02d977564d610
- LaravelアプリケーションをローカルでもAWSでもDockerで動かす
    - https://qiita.com/imunew/items/1e4826030d725beb4710

------

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
