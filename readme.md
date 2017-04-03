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
>name,phone,password,school_id
 | 请求参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| phone|  <mark>varchar,**不可为空且不与数据库内账号重复**</mark>|  手机号码,**作为登陆标识**|
| password |   varchar,**不可为空且大于6位**| 用户密码 |
| school_id | int |学校信息|
| name | varchar,选填 |用户姓名|
| idcard | varchar,选填|身份证|
|idcar_img|选填|身份证验证图片

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
> [/api/getSchools/{province_id} ](#)


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

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
| :-------- | :--------| :------ |
| success|   boolean|  请求成功与否|
| status_code|   Integer|  执行结果code|
|data|array|返回信息|

- **返回示例**
>    
```php
{
  "success": "true",
  "status_code": "200",
  "data": {
    "id": 1,
    "name": "陈旭斌",
    "phone": "15340521856",
    "email": "1065611145@qq.com",
    "idcard": null,
    "age": 19,
    "character_value": 50,
    "school_id": 2034,
    "gender": "男",
    "grade": "大二",
    "marital_status": "单身"
  }
}
```