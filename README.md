# 常用命令
- php bin/hyperf.php gen:migration create_users_table   生成数据库迁移文件
- php bin/hyperf.php migrate    执行数据库迁移
- php bin/hyperf.php gen:model table_name  生成模型
- php bin/hyperf.php gen:request FooRequest  生成验证表单

# 部署


- cp .env.example .env
- cp docker-compose.yml-dev docker-compose.yml
- docker build -t api-hyperf:latest .
- docker-compose up -d


# 重启
- docker-compose up -d --force-recreate api-hyperf

# 项目结构

```
├── app
│   ├── Controller  //控制器
│   │   └── UserController.php
│   └── Services  //服务层,主要业务逻辑由service实现
│   └── Repositories   //仓储层
│   └── Model   //模型层
│   ├── Middleware  //中间件
│   │   └── JwtAuthMiddleware.php
│   └── Annotation   //自定义注解
│       └── JwtIgnore.php
│   └── Command    //自定义命令行
│   └── Exception   //异常处理
│   └── Libraries   //自定义库
│   └── Listener    
│   └── Request     //请求验证器，固定请求格式，不需要在service写多余验证
│   └── Tools       //自定义工具类
│   └── Traits      
├── config
│   └── config.php
│   └── routes.php
├── migrations
├── classmap
├── composer.json
└── README.md
```




# 集成功能
- prometheus
- sentry / glitchTip
- crontab
- auth-jwt
