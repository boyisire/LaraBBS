# LaraBBS说明

## 学习目标
1. 多角色用户权限系统
2. 管理员后台
3. 注册验证码
4. 图片上传
5. 图片裁剪
6. XSS 防御
7. 自定义命令行
8. 自定义中间件
9. 任务调度
10. 队列系统的使用
11. 应用缓存
12. Redis
13. 模型事件监控
14. 表单验证
15. 消息通知
16. 邮件通知
17. 模型修改器
18. 现代化 Web 开发
>Git 工作流、前端工作流、GitHub 使用

## Rails框架原则
+ 强调与注重敏捷开发
+ 约定高于配置（Convention over configuration）
+ DRY（Don't repeat yourself）不要重复自己，提倡代码重用
+ 注重「编码愉悦性」

## 目录文件介绍

### 配置文件
下面是配置文件的简单说明：

| 文件名称 | 配置类型 |
| -------| -------|
| app.php | 应用相关，如项目名称、时区、语言等 |
| auth.php | 用户授权，如用户登录、密码重置等 |
| broadcasting.php | 事件广播系统相关配置 |
| cache.php | 缓存相关配置 |
| database.php | 数据库相关配置，包括 MySQL、Redis 等 |
| filesystems.php | 文件存储相关配置 |
| mail.php | 邮箱发送相关的配置 |
| queue.php | 队列系统相关配置 |
| services.php | 放置第三方服务配置 |
| session.php | 用户会话相关配置 |
| view.php | 视图存储路径相关配置 |


### 其他
1. 所有『自定义辅助函数』
`bootstrap/helpers.php`
>需要在 bootstrap/app.php 文件的最顶部进行加载
`require __DIR__ . '/helpers.php';`

2. 存放本项目的工具类
>『工具类（utility class）』是指一些跟业务逻辑相关性不强的类
`app/Handlers`

### 路由文件
`routes/web.php`
`routes/api.php`
#### 路由说明
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);


## 视图
### 前台布局文件
+ app.blade.php —— 主要布局文件，项目的所有页面都将继承于此页面；
+ _header.blade.php —— 布局的头部区域文件，负责顶部导航栏区块；
+ _footer.blade.php —— 布局的尾部区域文件，负责底部导航区块；


### 后台布局文件
+ 1). 数据表格 —— 对应选项 columns，用来列表数据，支持分页和批量删除；
+ 2). 模型表单 —— 对应选项 edit_fields，用来新建和编辑模型数据；
+ 3). 数据过滤 —— 对应选项 filters，与数据表格实时响应的表单，用来筛选数据

### 样式文件
`resources/assets/sass/app.scss`

## ......
.
.
.

## 论坛功能说明
### 角色
>角色的权限从低到高，高权限的用户将包含权限低的用户权限

- 游客 —— 没有登录的用户；
- 用户 —— 注册用户，没有多余权限；
- 管理员 —— 辅助超级管理员做社区内容管理；
- 站长 —— 权限最高的用户角色；

### 信息结构
+ 用户 —— 模型名称 User，论坛为 UGC 产品，所有内容都围绕用户来进行；
+ 话题 —— 模型名称 Topic，LaraBBS 论坛应用的最核心数据，有时我们称为帖子；
+ 分类 —— 模型名称 Category，话题的分类，每一个话题必须对应一个分类，分类由管理员创建；
+ 回复 —— 模型名称 Reply，针对某个话题的讨论，一个话题下可以有多个回复；

### 动作
>角色和信息之间的互动

+ 创建 Create
+ 查看 Read
+ 编辑 Update
+ 删除 Delete

### 用例
#### 1. 游客
1.1 游客可以查看所有话题列表；
1.2 游客可以查看某个分类下的所有话题列表；
1.3 游客可以按照发布时间和最后回复时间进行话题列表排序；
1.4 游客可以查看单个话题内容；
1.5 游客可以查看话题的所有回复；
1.6 游客可以通过注册按钮创建用户（用户注册，游客专属）；
1.7 游客可以查看用户的个人页面；

#### 2. 用户
2.1 用户可以在某个分类下发布话题；
2.2 用户可以编辑自己发布的话题；
2.3 用户可以删除自己发布的话题；
2.4 用户可以回复所有话题；
2.5 用户可以删除自己的回复；
2.6 用户可以编辑自己的个人资料；
2.7 用户可以接收话题新回复的通知；

#### 3. 管理员
3.1 管理员可以访问后台；
3.2 管理员可以编辑所有的话题；
3.3 管理员可以删除所有的回复；
3.4 管理员可以编辑分类；

#### 4. 站长
4.1 站长可以编辑用户；
4.2 站长可以删除用户；
4.3 站长可以修改站点设置；
4.4 站长可以删除分类；

## 表结构

在使用代码生成器之前，我们需要先整理好 `topics` 表的字段名称和字段类型：
### 话题表「topics」


| 字段名称 | 描述  | 字段类型 | 加索引缘由 | 其他 |
| -------- | -------- | -------- | -------- |
| `title` |  帖子标题 | 字符串（String） | 文章搜索 | 无 |
| `body` |  帖子内容 | 文本（text） | 不需要 | 无 |
| `user_id` |  用户 ID | 整数（int） | 数据关联 | `unsigned()` |
| `category_id` |  分类 ID | 整数（int） | 数据关联 | `unsigned()` |
| `reply_count` |  回复数量 | 整数（int） | 文章回复数量排序 | `unsigned()`, `default(0)` |
| `view_count` |  查看总数 | 整数（int） | 文章查看数量排序 | `unsigned()`, `default(0)` |
| `last_reply_user_id` |  最后回复的用户 ID | 整数（int） | 数据关联 | `unsigned()`, `default(0)` |
| `order` |  可用来做排序使用 | 整数（int） | 不需要 | `default(0)` |
| `excerpt` |  文章摘要，SEO 优化时使用 | 文本（text） | 不需要 | 无  |
| `slug` | SEO 友好的 URI |  字符串（String） | 不需要 |  `nullable()` |


- `unsigned()` —— 设置不需要标识符（unsigned）
- `default()` —— 为字段添加默认值。
- `nullable()` —— 可为空


.
.
.

......


## 全书总结
### 功能项
+ 用户认证 —— 注册、登录、退出；
+ 个人中心 —— 用户个人中心，编辑资料；
+ 用户授权 —— 作者才能删除自己的内容；
+ 上传图片 —— 修改头像和编辑话题时候上传图片；
+ 表单验证 —— 使用表单验证类；
+ 模型监控 —— 自动 Slug 翻译；
+ 使用第三方 API —— 请求百度翻译 API ；
+ 队列任务 —— 将百度翻译 API 请求和发送邮件放到队列中，以提高响应；
+ 计划任务 —— 『活跃用户』计算，一小时计算一次；
+ 多角色权限管理 —— 允许站长，管理员权限的存在；
+ 后台管理 —— 后台数据模型管理；
+ 邮件通知 —— 发送新回复邮件通知；
+ 站内通知 —— 话题有新回复；
+ 自定义 Artisan 命令行 —— 自定义活跃用户计算命令；
+ 自定义 Trait —— 活跃用户的业务逻辑实现；
+ 自定义中间件 —— 记录用户的最后登录时间；
+ 模型修改器；
+ XSS 安全防御；

### 功能点
- [自定义表单验证规则](https://d.laravel-china.org/docs/5.5/validation#using-extensions){:target="_blank"}
- [表单请求验证（FormRequest）](https://d.laravel-china.org/docs/5.5/validation#form-request-validation){:target="_blank"}
- [隐性路由模型绑定](http://d.laravel-china.org/docs/5.5/routing#%E9%9A%90%E5%BC%8F%E7%BB%91%E5%AE%9A){:target="_blank"}
- [请求对象（Request）](https://d.laravel-china.org/docs/5.5/requests#retrieving-uploaded-files){:target="_blank"}
- [Laravel 中间件 (Middleware)](http://d.laravel-china.org/docs/5.5/middleware){:target="_blank"}
- [授权策略 (Policy)](http://d.laravel-china.org/docs/5.5/authorization#policies){:target="_blank"}
- [数据填充 Seed](https://d.laravel-china.org/docs/5.5/seeding){:target="blank"}
- [批量入库](https://laravel-china.org/courses/laravel-specification/516/data-filling){:target="_blank"}
- [集合对象](https://d.laravel-china.org/docs/5.5/collections){:target="_blank"}
- [预加载功能](https://d.laravel-china.org/docs/5.4/eloquent-relationships#eager-loading){:target="_blank"}
- [本地作用域](https://d.laravel-china.org/docs/5.5/eloquent#local-scopes){:target="_blank"}
- [查询构建器](https://d.laravel-china.org/docs/5.5/queries){:target="_blank"}
- [一对多](https://d.laravel-china.org/docs/5.5/eloquent-relationships#one-to-many){:target="_blank"}
- [观察器](https://d.laravel-china.org/docs/5.5/eloquent#observers){:target="_blank"}
- [Laravel 服务容器](https://d.laravel-china.org/docs/5.5/container){:target="_blank"}
- [Laravel 队列监控面板 - Horizon](https://d.laravel-china.org/docs/5.5/horizon#Supervisor-%E9%85%8D%E7%BD%AE){:target:"_blank"}
- [策略过滤器](https://d.laravel-china.org/docs/5.5/authorization#policy-filters){:target="_blank"}
- [password_verify](http://php.net/manual/zh/function.password-verify.php){:target="_blank"}
- [Eloquent修改器](https://d.laravel-china.org/docs/5.5/eloquent-mutators){:target="_blank"}
- [Laravel 中间件](https://d.laravel-china.org/docs/5.5/middleware){:target="_blank"}
- [访问器](https://d.laravel-china.org/docs/5.5/eloquent-mutators#defining-an-accessor){:target="_blank"}


## 操作命令

### artisan
#### 创建控制器
`php artisan make:controller PagesController`

#### 生成配置文件
`php artisan vendor:publish`

#### 用户认证
`php artisan make:auth`

#### 创建用户表单数据验证
`php artisan make:request UserRequest`

#### 生成迁移文件:添加表字段
`php artisan make:migration add_avatar_and_introduction_to_users_table --table=users`

#### 创建模型,并生成迁移文件
`php artisan make:model Models/Category -m`

#### 在users表中新建字段
`php artisan make:migration add_last_actived_at_to_users_table --table=users`

#### 执行数据迁移
`php artisan migrate`

#### 批量插入数据
`php artisan db:seed`

#### 回滚数据库的所有迁移,并重新填充数据
`php artisan migrate:refresh --seed`

#### 创建授权策略类文件
`php artisan make:policy UserPolicy`

#### 队列处理
`php artisan queue:failed-table`

#### 队列监听
`php artisan queue:listen`

#### 队列任务添加
`php artisan make:job TranslateSlug`

#### 消息系统表
`php artisan notifications:table`

#### 创建通知类
`php artisan make:notification TopicReplied`

#### Crontab任务计划
`php artisan schedule:run >> /dev/null 2>&1`

#### 清空缓存
`php artisan cache:clear`

#### 创建中间件
`php artisan make:middleware RecordLastActivedTime`

#### 创建命令
`php artisan make:command SyncUserActivedAt --command=larabbs:sync-user-actived-at`

### Composer
#### 使用 Composer 创建一个名为 LaraBBS 的应用
`composer create-project laravel/laravel larabbs --prefer-dist "5.5.*"`
>其它详见[插件管理](#插件管理)

### Git
#### 初始化仓库
`git init`
#### 添加文件
`git add -A`
#### 提交描述
`git commit -m "XXXXXXX"`
#### 添加远程仓库
`git remote add origin git@github.com:<username>/larabbs.git`
#### 提交到远程库
`git push -u origin master`
#### 查看文件修改状态
`git status`
#### 回滚
`php artisan migrate:rollback`
#### 还原修改文件到原始状态
`git checkout .`
#### 强制清理项目新增文件及文件夹
`git clean -f -d `
#### .gitignore机制
>不想让某个文件夹中的文件提交git,添加`.gitignore` 文件处理.

```
*
!.gitignore
```

### Laravel Mix
>Laravel Mix 一款前端任务自动化管理工具，使用了工作流的模式对制定好的任务依次执行。
Mix 提供了简洁流畅的 API，让你能够为你的 Laravel 应用定义 Webpack 编译任务。
Mix 支持许多常见的 CSS 与 JavaScript 预处理器，通过简单的调用，你可以轻松地管理前端资源。

#### 为 Yarn 配置安装加速
`yarn config set registry https://registry.npm.taobao.org`

#### 使用 Yarn 安装依赖
`yarn install`

#### 自动编译资源文件
`npm run watch-poll`
>该命令需一直保持在运行状态





## 插件管理
>本文主要用到的插件

[EditorConfig](https://atom.io/packages/editorconfig)
>用Atom开发所用的样式控制插件

[whoops](https://github.com/filp/whoops)
>whoops 是一个非常优秀的 PHP Debug 扩展，它能够使你在开发中快速定位出错的位置

[mews/captcha](https://github.com/mewebstudio/captcha)
>图片验证码功能

>**安装:** `composer require "mews/captcha:~2.0"`

[overtrue/laravel-lang ](https://github.com/overtrue/laravel-lang/)
>多语言版本翻译

>**安装:** `composer require "overtrue/laravel-lang:~3.0"`

[Carbon](https://github.com/briannesbitt/Carbon)
>PHP 知名的 DateTime 操作扩展，Laravel 将其默认集成到了框架中

[UploadedFile](http://api.symfony.com/3.0/Symfony/Component/HttpFoundation/File/UploadedFile.html)
>Laravel 的『用户上传文件对象』底层使用了 Symfony 框架的 UploadedFile 对象进行渲染，为我们提供了便捷的文件读取和管理接口

[Intervention/image](https://github.com/Intervention/image)
>图像处理和操作

[GD 库](http://php.net/manual/zh/intro.image.php)
[ImageMagic](http://php.net/manual/zh/intro.imagick.php)
>一般默认使用 gd ，如果将要开发的项目需要较专业的图片，请考虑 ImageMagic

[ Laravel 5.x Scaffold Generator ](https://github.com/summerblue/generator)
>代码生成器能让你通过执行一条 Artisan 命令，完成注册路由、新建模型、新建表单验证类、新建资源控制器以及所需视图文件等任务，不仅约束了项目开发的风格，还能极大地提高我们的开发效率。

>**安装:** `composer require 'summerblue/generator:~0.5' --dev`

>**操作:** `php artisan make:scaffold Topic --schema="title:string:index,body:text,user_id:integer:unsigned:index,category_id:integer:unsigned:index,reply_count:integer:unsigned:default(0),view_count:integer:unsigned:default(0),last_reply_user_id:integer:unsigned:default(0),order:integer:unsigned:default(0),excerpt:text,slug:string:nullable"`

>**清单:**
+ 创建话题的数据库迁移文件 —— 2017_09_26_111713_create_topics_table.php；
+ 创建话题数据工厂文件 —— TopicFactory.php；
+ 创建话题数据填充文件 —— TopicsTableSeeder.php；
+ 创建模型基类文件 —— Model.php， 并创建话题数据模型；
+ 创建话题控制器 —— TopicsController.php；
+ 创建表单请求的基类文件 —— Request.php，并创建话题表单请求验证类；
+ 创建话题模型事件监控器 TopicObserver 并在 AppServiceProvider 中注册；
+ 创建授权策略基类文件 —— Policy.php，同时创建话题授权类，并在 AuthServiceProvider 中注册；
+ 在 web.php 中更新路由，新增话题相关的资源路由；
+ 新建符合资源控制器要求的三个话题视图文件，并存放于 resources/views/topics 目录中；
+ 执行了数据库迁移命令 artisan migrate；
+ 因此次操作新建了多个文件，最终执行 composer dump-autoload 来生成 classmap。

[Faker](https://github.com/fzaninotto/Faker)
>Faker 是一个假数据生成库,默认基础在Laravel中

[laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
>**安装:** `composer require "barryvdh/laravel-debugbar:~3.1" --dev`

>**配置:** `php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"`

[导航栏组件](https://getbootstrap.com/docs/3.3/components/#navbar)
>Bootstrap 框架的 导航栏组件,实现导航栏选中状态效果

>**安装:** `composer require "hieu-le/active:~3.5"`

[Simditor](http://simditor.tower.im/)
>Simditor 是 tower.im 团队的开源编辑器

>**下载:** [点击此处下载 Simditor](https://github.com/mycolorway/simditor/releases/download/v2.3.6/simditor-2.3.6.zip)

[HTMLPurifier for Laravel](https://github.com/mewebstudio/Purifier)
>HTMLPurifier 针对 Laravel 框架的一个封装,HTMLPurifier 本身就是一个独立的项目，运用『白名单机制』对 HTML 文本信息进行 XSS 过滤

>**安装:** `composer require "mews/purifier:~2.0"`

>**配置:** `php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"`

[Guzzle](https://github.com/guzzle/guzzle)
>Guzzle 库是一套强大的 PHP HTTP 请求套件

>**安装:** `composer require "guzzlehttp/guzzle:~6.3"`

[百度翻译](http://api.fanyi.baidu.com/api/trans/product/apidoc)

[PinYin](https://github.com/overtrue/pinyin)
>PinYin 是 安正超 开发的，基于 CC-CEDICT 词典的中文转拼音工具，是一套优质的汉字转拼音解决方案。

>**安装:** `composer require "overtrue/pinyin:~3.0"`

[Redis](https://github.com/nrk/predis)
>用redis 做队列驱动器
>**安装:** `composer require "predis/predis:~1.0"`
>**配置:** .env = `QUEUE_DRIVER=redis`

[Horizon](https://d.laravel-china.org/docs/5.5/horizon)
>Horizon 是 Laravel 生态圈里的一员，为 Laravel Redis 队列提供了一个漂亮的仪表板，允许我们很方便地查看和管理 Redis 队列任务执行的情况。

>**安装:** `composer require "laravel/horizon:~1.0"`

>**配置:** `php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"`

>**执行:** `php artisan horizon` (需要常驻运行)

[Laravel-permission](https://github.com/spatie/laravel-permission)
>实现的权限和角色的管理

>**安装:** `composer require "spatie/laravel-permission:~2.7"`

>**配置:** `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"`

>**数据表:**
> + roles —— 角色的模型表；
> + permissions —— 权限的模型表；
> + model_has_roles —— 模型与角色的关联表，用户拥有什么角色在此表中定义，一个用户能拥有多个角色；
> + role_has_permissions —— 角色拥有的权限关联表，如管理员拥有查看后台的权限都是在此表定义，一个角色能拥有多个权限；
> + model_has_permissions —— 模型与权限关联表，一个模型能拥有多个权限;

[sudo-su](https://github.com/viacreative/sudo-su)
>用户切换工具

>**安装:** `composer require "viacreative/sudo-su:~1.1"`

>**配置:** `php artisan vendor:publish --provider="VIACreative\SudoSu\ServiceProvider"`

[Laravel Administrator](https://github.com/summerblue/administrator)
>管理员后台

>**安装:** `composer require "viacreative/sudo-su:~1.1"`

>**配置:** `php artisan vendor:publish --provider="Frozennode\Administrator\AdministratorServiceProvider"`


## 扩展阅读
### IBM 文档库：跨站点脚本攻击深入解析 
[跨站点脚本攻击深入解析](https://www.ibm.com/developerworks/cn/rational/08/0325_segal/)
### 开发规范
[ Laravel 项目开发规范](https://laravel-china.org/courses/laravel-specification){:target="_blank"}


## 名称解释
**UGC:** 互联网术语，全称为User Generated Content，也就是用户生成内容的意思。UGC的概念最早起源于互联网领域，即用户将自己原创的内容通过互联网平台进行展示或者提供给其他用户。UGC是伴随着以提倡个性化为主要特点的Web2.0概念兴起的。

**XSS:** XSS攻击全称跨站脚本攻击，是为不和层叠样式表(Cascading Style Sheets, CSS)的缩写混淆，故将跨站脚本攻击缩写为XSS，XSS是一种在web应用中的计算机安全漏洞，它允许恶意web用户将代码植入到提供给其它用户使用的页面中。
