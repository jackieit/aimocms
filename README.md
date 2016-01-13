# aimocms
  aimocms 是一个站群CMS适应于门户站及建站公司的企业群建站。

# Install
  * 自行手动安装vendor 库
  ```php composer.par install```      
  * 设定开发还是生产环境，然后编辑 common/config/main-local.php file 设置数据库连接参数（需要手动创建数据库）
  ```./init```  
            
  * 创建数据库表结构和数据
   ```./yii migrate/up```   
  
# 权限相关
  [权限设计](docs/idea.md)