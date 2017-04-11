# MeetU接口文档

[TOC]

## 说明(status_code)

>| 状态编码      |     参数类型 |  
>| :-------- | :--------|
>|2000|   处理成功| 
>|2001|创建用户成功|
>|2002|修改用户信息成功|
>|4000|客户端请求错误|
>|4001|用户名或密码错误|
>|4003|请求参数出错|
>|4004|未找到相关信息|
>|4011|token过期|
>|4012|token无效|
>|4013|缺少token|
>|4022|手机号码出错|
>|4023|身份证号码出错|
>|4024|密码出错|
>|4025|必须上传图片|
>|5000|服务器发生错误| 

## 登录注册模块

#### 接口说明 1、注册

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/register ](#)

- **请求方式** 
>**POST**

- **请求参数**
>| 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| phone|  <mark>varchar,**不可为空且不与数据库内账号重复**</mark>|  手机号码,**作为登陆标识**|
>| password |   varchar,**不可为空且大于6位**| 用户密码 |
>|nickname|varchar,**不可为空**|昵称|
>|gender|int，**不可为空，0为女 1为男** |性别
>|description| varchar，选填|个人描述|
>|name|varchar，选填，用于实名验证|真实姓名|
>|idcard|varchar，选填，用于实名验证|身份证号|
>|school_id|varchar，选填|学校id|
>|student_id|varchar，选填|学号|
>|QQ|varchar，选填|QQ|
>|WeChat|varchar，选填|微信|
>|WeiBo|varchar，选填|微博|
>|Facebook|varcahr，选填|Facebook|
>|Instagram|varchar，选填|Instagram|
>|Twitter|varchar，选填|Twitter|
>|photo|file，选填|验证图片1|
>|photo2|file，选填|验证图片2|

- **返回参数**
>| 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|token|varchar|注册成功即保持登录状态|

- **返回示例**
>    
```php
{
  "status_code": "2000",
  "info": "success",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvbWVldHVcL2FwaVwvdXNlclwvbG9naW4iLCJpYXQiOjE0OTE3NDA4OTcsImV4cCI6MTQ5MTc0NDQ5NywibmJmIjoxNDkxNzQwODk3LCJqdGkiOiI2MDliYWVkZWJhODIzOWI2ZDFlMmU4NDgwYjY5YzZiYiJ9.VPqPOr4FkmWTMgSzRXedhLdCjZpcbAJHtOHBa2E_r-8"
}
```

- **错误返回示例**
>    
```php
{
  "status_code": "4022",
  "info": "该手机已被注册!",
  "token": ""
}
```

#### 接口说明 2、登陆

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/login](#)


- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| phone|   varchar,不可为空|  用户手机号|
>| password|   varchar,不可为空|  密码|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|登录信息|
>|token|varchar|唯一标识token|

- **返回示例**
>    
```php
{
  "status_code": "2000",
  "info": "success",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvbWVldHVcL2FwaVwvdXNlclwvbG9naW4iLCJpYXQiOjE0OTE3Mzc2NzAsImV4cCI6MTQ5MTc0MTI3MCwibmJmIjoxNDkxNzM3NjcwLCJqdGkiOiJjNzE0MWI1NTJkMGU0MzAzZWQyNjE1MjZlY2NhMGNhNiJ9.zlt190JTj0M8hMYiGyNYnmXayQgIn0LWF1UND56NVsE"
}
```

#### 接口说明 3、获取省份列表

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/getProvinces](#)


- **请求方式** 
>**GET**

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>| data|   array|  省份列表|
>|province_id|int|省份id|
>|province_name|varchar|省份名称|

- **返回示例**
>    
```php
{
  "status_code": "2000",
  "info": "success",
  "data": [
    {
      "province_id": 1,
      "province_name": "北京"
    },
}
```

#### 接口说明 4、获取某省份学校列表

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/getSchools ](#)


- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| province_id|   int| 省份id|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>| data|   array|  学校列表|
>|data:school_id|int|学校id|
>|data:school_name|varchar|学校名称

- **返回示例**
>    
```php
{
  "status_code": "2000",
  "info": "success",
  "data": [
    {
      "school_id": 2031,
      "school_name": "重庆大学"
    },
}
```

#### 接口说明 5、获取用户信息

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/info?token=TOKEN](#)


- **请求方式** 
>**POST**

- **请求参数**
>| 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|

- **成功返回**
>| 返回参数|参数类型 |参数说明   |
>| :-------- | :--------| :------ |
>| success|   boolean|  请求成功与否|
>| status_code|   Integer|  执行结果code|
>|data|array|返回信息|
>|character_value|int|人品值|
>|marital_status|varchar|情感状态|
>|verify|bool|是否通过实名验证，0为否，1为是|
>|QQ|varchar|QQ|
>|WeChat|varchar|微信|
>|WeiBo|varchar|微博|
>|FaceBook|varchar|FaceBook|
>|Instagram|varchar|Instagram|
>|Twitter|varchar|Twitter|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "2000",
  "data": {
    "id": 1,
    "name": "陈旭斌",
    "nickname": "XB",
    "phone": "15340521856",
    "age": 19,
    "character_value": 50,
    "student_id": null,
    "gender": "男",
    "grade": "大二",
    "marital_status": "单身",
    "verify": 0,
    "school_name": "重庆邮电大学",
  "QQ": null,
  "WeChat": null,
  "WeiBo": null,
  "FaceBook": null,
  "Instagram": null,
  "Twitter": null,
    }
  }
}
```

- **错误返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| success|   boolean|  请求成功与否|
>| status_code|   Integer|  状态码 |
>|msg|array|错误信息|

- **返回示例**
>    
```php
{
  "status_code": "402",
  "info": "缺少token",
  "data": ""
}
```

#### 接口说明 6、刷新TOKEN

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/upToken?token=TOKEN](#)

- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|token|varchar|新生成的token，原token失效|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvbWVldHVcL3B1YmxpY1wvYXBpXC91c2VyXC9sb2dpbiIsImlhdCI6MTQ5MTE4NjY0OCwiZXhwIjoxNDkxMTkwMjQ4LCJuYmYiOjE0OTExODY2NDgsImp0aSI6IjY3Mjg4M2E5NTY2NzhlYzA0OTg1ZWYzYTk5MTBmYjdkIn0.gfQvOUtV0wtlwbCoLKtm-fPv7HaU-LcZPQfC8E7oP90"
}
```

#### 接口说明 7、修改密码

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/changePwd?token=](#)

- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|
>|newPassword|varchar,不可为空，大于6位|新密码|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varcahr|返回信息|
>|msg|varchar|返回信息|

- **返回示例**
>    
```php
{
  "status_code": "2002",
  "info": "修改成功"
}
```


#### 接口说明 8、模糊查询学校

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/findSchool/{keywords}](#)

- **请求示例**
> [https://xbbbbbb.cn/MeetU/api/findSchool/重庆](#)

- **请求方式** 
>**GET**

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|array|返回信息|
>|data:school_id|int|学校id|
>|data:school_name|varchar|学校名称|

- **返回示例**
>    
```php
{
  "status_code": "2000",
  "info": "success",
  "data": [
    {
      "school_id": 3,
      "school_name": "北京交通大学"
    },
    {
      "school_id": 4,
      "school_name": "北京航空航天大学"
    },
}
```