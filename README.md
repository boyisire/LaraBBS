# LaraBBS


## 常用命令

### 自动重新编译资源文件
`npm run watch-poll`

### 刷新数据库,重新生成数据
`php artisan migrate:refresh --seed`

### 创建中间件
`php artisan make:middleware RecordLastActivedTime`

### 在 [users] 表中新建字段
`php artisan make:migration add_last_actived_at_to_users_table --table=users`

### 执行数据迁移
`php artisan migrate`