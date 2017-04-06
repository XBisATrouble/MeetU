# MeetU接口文档

[TOC]

## 状态码说明(status_code)
> | 状态编码      |     参数类型 |  
| :-------- | :--------|
| 200|   处理成功| 
| 400|   客户端请求错误| 
| 500|   服务器错误| 

## 登录注册模块

#### 接口说明 **1、**注册

- **请求URL**
> [/api/user/register ](#)

- **请求方式** 
>**POST**

- **请求参数**
 >| 请求参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| phone|  <mark>varchar,**不可为空且不与数据库内账号重复**</mark>|  手机号码,**作为登陆标识**|
| password |   varchar,**不可为空且大于6位**| 用户密码 |
|nickname|varchar,**不可为空且不与数据库内账号重复**|昵称|
|gender|int，**不可为空，0为女 1为男** |性别
|description| varchar，选填|个人描述|
|name|varchar，选填，用于实名验证|真实姓名|
|idcard|varchar，选填，用于实名验证|身份证号|
|school_id|varchar，选填|学校id|
|student_id|varchar，选填|学号|
|QQ|varchar，选填|QQ|
|WeChat|varchar，选填|微信|
|WeiBo|varchar，选填|微博|
|BaiduPostBar|varchar，选填|百度贴吧|
|Facebook|varcahr，选填|Facebook|
|Instagram|varchar，选填|Instagram|
|Twitter|varchar，选填|Twitter|


- **返回参数**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  执行结果code|
| msg|   String|  执行结果消息|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
  "msg": "创建用户成功"
}
```

#### 接口说明 **2、**登陆

- **请求URL**
> [/api/user/login](#)


- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| phone|   varchar,不可为空|  用户手机号|
| password|   varchar,不可为空|  密码|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  执行结果code|
|token|varchar|唯一标识token|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvbWVldHVcL3B1YmxpY1wvYXBpXC91c2VyXC9sb2dpbiIsImlhdCI6MTQ5MTE4NjY0OCwiZXhwIjoxNDkxMTkwMjQ4LCJuYmYiOjE0OTExODY2NDgsImp0aSI6IjY3Mjg4M2E5NTY2NzhlYzA0OTg1ZWYzYTk5MTBmYjdkIn0.gfQvOUtV0wtlwbCoLKtm-fPv7HaU-LcZPQfC8E7oP90"
}
```

#### 接口说明 **3、**获取省份列表

- **请求URL**
> [/api/getProvinces ](#)


- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  执行结果code|
| data|   array|  省份列表|
|province_id|int|省份id|
|province_name|varchar|省份名称|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
  "data": [
    {
      "province_id": 1,
      "province_name": "北京"
    },...
   ],
}
```

#### 接口说明 **4、**获取某省份学校列表

- **请求URL**
> [/api/getSchool/{province_id} ](#)


- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| province_id|   int| 省份id|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  执行结果code|
| data|   array|  学校列表|
|school_id|int|学校id|
|school_name|varchar|学校名称

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
  "data": [
    {
      "school_id": 111,
      "school_name": "南开大学"
    },...
  ]
}
```

#### 接口说明 **5、**获取用户信息

- **请求URL**
> [/api/user/info?token=](#)


- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| token | varchar|登陆后返回的token|
- **成功返回**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  执行结果code|
|data|array|返回信息|
|character_value|int|人品值|
|marital_status|varchar|情感状态|
|verify|bool|是否通过实名验证，0为否，1为是|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
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
    "QQ": null,
    "WChat": null,
    "WeiBo": null,
    "BaiduPostBar": null,
    "FaceBook": null,
    "Instagram": null,
    "Twitter": null,
    "verify": 0,
    "school_name": "重庆邮电大学"
  }
}
```

- **错误返回**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  状态码 **404:未找到相关用户，401:token已过期，402:缺少token，403:token无效**|
|msg|array|错误信息|

- **返回示例**
>    
```php
{
  "success": "false",
  "status_code": "403",
  "msg": "token无效"
}
```

#### 接口说明 **6、**刷新TOKEN

- **请求URL**
> [/api/user/upToken](#)

- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| token|varchar|旧token|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  执行结果code|
|token|varchar|新生成的token，原token失效|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvbWVldHVcL3B1YmxpY1wvYXBpXC91c2VyXC9sb2dpbiIsImlhdCI6MTQ5MTE4NjY0OCwiZXhwIjoxNDkxMTkwMjQ4LCJuYmYiOjE0OTExODY2NDgsImp0aSI6IjY3Mjg4M2E5NTY2NzhlYzA0OTg1ZWYzYTk5MTBmYjdkIn0.gfQvOUtV0wtlwbCoLKtm-fPv7HaU-LcZPQfC8E7oP90"
}
```

#### 接口说明 **7、**修改密码

- **请求URL**
> [/api/user/changePwd?token=](#)

- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| token|varchar|token|
|newPassword|varchar,不可为空，大于6位|新密码|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  执行结果code|
|msg|varchar|返回信息|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
  "msg": "修改成功"
}
```