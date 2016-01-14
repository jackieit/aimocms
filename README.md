# aimocms
  aimocms 是一个站群CMS适应于门户站及建站公司的企业群建站。

# Install
  * 安装 composer-asset-plugin  
  ```composer global require "fxp/composer-asset-plugin:~1.1.1"```    
  * 自行手动安装vendor 库    
  ```php composer.par install```      
  * 设定开发还是生产环境，然后编辑 common/config/main-local.php file 设置数据库连接参数（需要手动创建数据库）   
  ``` ./init ```  
  * 创建数据库表结构和数据    
  ```./yii migrate/up```   
  * done  
# 权限相关
  [权限设计](docs/idea.md)  
# 需求分析  
  [功能需求](https://github.com/jackieit/aimocms/wiki/Requirements)
