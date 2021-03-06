# MeetU接口文档

[TOC]

## 说明

#### 1、状态码

>| 状态编码      |     参数类型 |  
>| :-------- | :--------|
>|2000|   处理成功| 
>|2001|创建用户成功|
>|2002|修改用户信息成功|
>|2003|修改活动信息成功|
>|2004|返回结果为空|
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
>|4030|无权操作|
>|4040|您已参加该活动|
>|4041|用户关注出错|
>|5000|服务器发生错误| 

#### 2、时间格式
>yyyy-MM-dd HH:mm:ss, 如"2017年4月22日11:02:43"

## 用户模块

### 用户授权模块 
* **对token的一些授权操作**

#### 接口说明 1、登陆

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/auth](https://xbbbbbb.cn/MeetU/api/auth)


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
```json
{
  "status_code": "2000",
  "info": "success",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvbWVldHVcL2FwaVwvdXNlclwvbG9naW4iLCJpYXQiOjE0OTE3Mzc2NzAsImV4cCI6MTQ5MTc0MTI3MCwibmJmIjoxNDkxNzM3NjcwLCJqdGkiOiJjNzE0MWI1NTJkMGU0MzAzZWQyNjE1MjZlY2NhMGNhNiJ9.zlt190JTj0M8hMYiGyNYnmXayQgIn0LWF1UND56NVsE"
}
```

#### 接口说明 2、更新TOKEN

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/auth](https://xbbbbbb.cn/MeetU/api/auth)

- **请求方式** 
>**PUT**

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
```json
{
  "status_code": "2000",
  "info": "success",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvTWVldFVcL2FwaVwvdXNlclwvdXBUb2tlbiIsImlhdCI6MTQ5MjU5MDU3NSwiZXhwIjoxNDkyNTk0MTgyLCJuYmYiOjE0OTI1OTA1ODIsImp0aSI6ImNmNjQwMWUxODIyOTFhMjE2YjA1NzgxMTZjYmY3N2RjIn0.bIrCLiAbgHB7Y8vehkmlT7Aqk2646hkfMYVP6_FsmfQ"
}
```

#### 接口说明 3、退出登录

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/auth](https://xbbbbbb.cn/MeetU/api/auth)

- **请求方式** 
>**DELETE**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|token|varchar|此token失效|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "退出成功",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjksImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvTWVldFVcL2FwaVwvYXV0aCIsImlhdCI6MTQ5MzExMTczMCwiZXhwIjoxNDkzMTMzMzMwLCJuYmYiOjE0OTMxMTE3MzAsImp0aSI6ImE1YjBiYWY0MDVkNzIwNzBjNmExNDBiOGIxNDMwOTgyIn0.sOGejuL_BnP38oE1CIIWzO-BF3vxphS4cvgn3P-Smb4"
}
```

### users模块
* **非私有信息，均返回简化版用户信息，无需授权即可访问**

#### 接口说明 1、获取所有用户列表

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/users](https://xbbbbbb.cn/MeetU/api/users)

- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|since|int，可选参数|起始元素|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|object|结果用户对象|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "data": [
        {
            "id": 1,
            "nickname": "XB",
            "avatar": "/public/uploads/avatars/default_man.png",
            "age": 19,
            "character_value": 50,
            "gender": "男",
            "followers_count": 0,
            "description": "运动健儿",
            "school_name": "重庆邮电大学"
        },
    ]
}
```

#### 接口说明 2、获取单个用户
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/users/{user_id}](https://xbbbbbb.cn/MeetU/api/users/{user_id})

- **请求方式** 
>**GET**

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|object|结果用户对象|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "data": {
        "id": 1,
        "nickname": "XB",
        "avatar": "/public/uploads/avatars/default_man.png",
        "age": 19,
        "character_value": 50,
        "gender": "男",
        "followers_count": 0,
        "description": "运动健儿",
        "school_name": "重庆邮电大学"
    }
}
```

#### 接口说明 3、注册

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/users ](https://xbbbbbb.cn/MeetU/api/users)

- **注册时同时注册环信账号，账号为手机，密码为000000**

- **请求方式** 
>**POST**

- **请求参数**
>| 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| phone|  <mark>varchar,**不可为空且不与数据库内账号重复**</mark>|  手机号码,**作为登陆标识**|
>| password |   varchar,**不可为空且大于6位**| 用户密码 |
>|nickname|varchar,**不可为空**|昵称|
>|gender|int，**不可为空，0为女 1为男** |性别|
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
>|user|object|用户实例|

- **返回示例**
>    
```json
{
  "status_code": "2001",
  "info": "注册成功",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjksImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvTWVldFVcL2FwaVwvdXNlcnMiLCJpYXQiOjE0OTMwNDk0NzksImV4cCI6MTQ5MzA3MTA3OSwibmJmIjoxNDkzMDQ5NDc5LCJqdGkiOiJjMDM1N2IzMjUwNjBlYmIzZWQ0YTA3NWY2NzBlZDM2ZiJ9.aD8aStaQ1b2xAryMqr6ewNVAI6QI-xogdaNhrrq3I1A",
  "user": {
    "phone": "15055512352",
    "nickname": "Tom",
    "gender": "男",
    "description": null,
    "name": null,
    "QQ": null,
    "WeChat": null,
    "WeiBo": null,
    "FaceBook": null,
    "Instagram": null,
    "Twitter": null,
    "verify_photo": null,
    "verify_photo_2": null,
    "id": 9,
    "school": null
  }
}
```

- **错误返回示例**
>    
```json
{
  "status_code": "4022",
  "info": "该手机已被注册!",
  "token": ""
}
```

#### 接口说明 4、获取关注某个用户的人
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/users/{user_id}/followers](https://xbbbbbb.cn/MeetU/api/users/{user_id}/followers)

- **请求方式** 
>**GET**

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|total|int|返回结果数|
>|data|object|结果用户对象|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 2,
    "data": [
        {
            "id": 8,
            "nickname": "Tom",
            "age": null,
            "character_value": 50,
            "gender": "男",
            "description": null,
            "school": "首都经济贸易大学"
        },
        {
            "id": 1,
            "nickname": "XB",
            "age": 19,
            "character_value": 50,
            "gender": "男",
            "description": null,
            "school": "重庆邮电大学"
        }
    ]
}
```

#### 接口说明 5、获取某个用户关注的人
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/users/{user_id}/following](https://xbbbbbb.cn/MeetU/api/users/{user_id}/following)

- **请求方式** 
>**GET**

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|total|int|返回结果数|
>|data|object|结果用户对象|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 2,
    "data": [
        {
            "id": 1,
            "nickname": "XB",
            "age": 19,
            "character_value": 50,
            "gender": "男",
            "description": null,
            "school": "重庆邮电大学"
        },
        {
            "id": 3,
            "nickname": "kubiXB",
            "age": null,
            "character_value": 50,
            "gender": "男",
            "description": null,
            "school": "天津商业大学"
        }
    ]
}
```


### user模块
* **授权后才能使用，和用户的个人私有操作有关**


#### 接口说明 1、获取认证用户个人信息

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user](https://xbbbbbb.cn/MeetU/api/user)


- **请求方式** 
>**GET**

- **请求参数**
>| 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|

- **成功返回**
>| 返回参数|参数类型 |参数说明   |
>| :-------- | :--------| :------ |
>| success|   boolean|  请求成功与否|
>| status_code|   Integer|  执行结果code|
>|data|object|返回信息|
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
```json
{
  "status_code": "2000",
  "info": "success",
  "data": {
    "id": 9,
    "name": "",
    "nickname": "Tom",
    "phone": "15055512352",
    "age": "",
    "character_value": 50,
    "gender": "男",
    "grade": "",
    "marital_status": "",
    "QQ": "",
    "WeChat": "",
    "WeiBo": "",
    "FaceBook": "",
    "Instagram": "",
    "Twitter": "",
    "verify": "",
    "description": "",
    "verify_photo": "",
    "verify_photo_2": "",
    "school": ""
  }
}
```

- **错误返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  状态码 |
>|info|varchar|错误信息|

- **返回示例**
>    
```json
{
  "status_code": "402",
  "info": "缺少token",
  "data": ""
}
```

#### 接口说明 2、修改认证用户密码

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/changePwd](https://xbbbbbb.cn/MeetU/api/user/changePwd)

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
```json
{
  "status_code": "2002",
  "info": "修改成功"
}
```

#### 接口说明 3、更新用户信息

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user ](https://xbbbbbb.cn/MeetU/api/user)

- **请求方式** 
>**PUT**

- **请求参数**
>| 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|
>|nickname|varchar,**不可为空**|昵称|
>|gender|int，**不可为空，0为女 1为男** |性别|
>|description| varchar，选填|个人描述|
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
>|user|object|用户实例|

- **返回示例**
>    
```json
{
  "status_code": "2001",
  "info": "更新成功",
  "data": {
    "id": 9,
    "name": null,
    "nickname": "Toby",
    "phone": "15055512352",
    "age": null,
    "character_value": 50,
    "gender": "男",
    "grade": null,
    "marital_status": "",
    "QQ": null,
    "WeChat": null,
    "WeiBo": null,
    "FaceBook": null,
    "Instagram": null,
    "Twitter": null,
    "verify": 0,
    "description": null,
    "verify_photo": null,
    "verify_photo_2": null,
    "school": null
  }
}
```

#### 接口说明 4、授权用户获取单个用户
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/{user_id}](https://xbbbbbb.cn/MeetU/api/user/{user_id})

- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|object|结果用户对象|
>|data.QQ\WeiBo...|varchar|用户的联系方式，若该授权用户和此用户互相关注则显示|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "data": {
        "id": 1,
        "nickname": "XB",
        "age": 19,
        "character_value": 50,
        "gender": "男",
        "description": "",
        "school": "重庆邮电大学"
    }
}
```

#### 接口说明 5、授权用户关注他人
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/following/{user_id}](https://xbbbbbb.cn/MeetU/api/user/following/{user_id})

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

- **返回示例**
>    
```json
{
  "status_code": "4041",
  "info": "关注成功"
}
```

#### 接口说明 6、授权用户取关他人
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/following/{user_id}](https://xbbbbbb.cn/MeetU/api/user/following/{user_id})

- **请求方式** 
>**DELETE**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|

- **返回示例**
>    
```json
{
  "status_code": "4041",
  "info": "取关成功"
}
```

#### 接口说明 7、获取关注授权用户的人
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/followers](https://xbbbbbb.cn/MeetU/api/user/followers)

- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|object|结果用户对象|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 2,
    "data": [
        {
            "id": 2,
            "nickname": "zs",
            "avatar": "/images/avatars/default.png",
            "age": null,
            "character_value": 50,
            "gender": null,
            "description": null,
            "school": "中国人民大学"
        },
        {
            "id": 3,
            "nickname": "kubiXB",
            "avatar": "/images/avatars/default.png",
            "age": null,
            "character_value": 50,
            "gender": "男",
            "description": null,
            "school": "天津商业大学"
        }
    ]
}
```

#### 接口说明 8、获取授权用户关注的人
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/following](https://xbbbbbb.cn/MeetU/api/user/following)

- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|object|结果用户对象|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 2,
    "data": [
        {
            "id": 2,
            "nickname": "zs",
            "avatar": "/images/avatars/default.png",
            "age": null,
            "character_value": 50,
            "gender": null,
            "description": null,
            "school": "中国人民大学"
        },
        {
            "id": 3,
            "nickname": "kubiXB",
            "avatar": "/images/avatars/default.png",
            "age": null,
            "character_value": 50,
            "gender": "男",
            "description": null,
            "school": "天津商业大学"
        }
    ]
}
```

#### 接口说明 9、修改头像
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/avatar](https://xbbbbbb.cn/MeetU/api/user/avatar)

- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|
>|photo|file，必填|头像图片，目前可以为png和jpg|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|object|返回头像地址，也可以通过user接口中的avatar取|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "上传成功",
  "data": "/public/uploads/avatars/1.jpg"
}
```

#### 接口说明 10、上传验证图片
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/verify](https://xbbbbbb.cn/MeetU/api/user/verify)

- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|
>|photo|file，必填|头像图片，目前可以为png和jpg|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|||该图片位于非公开目录，仅后台系统能访问|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "上传成功",
}
```

#### 接口说明 11、更新用户位置
- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/user/location](https://xbbbbbb.cn/MeetU/api/user/location)

- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar|调用接口凭证|
>|lng|varchar|经度|
>|lat|varchar|纬度|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "操作成功",
}
```

## 活动模块

#### 接口说明 1、获取活动列表

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity](https://xbbbbbb.cn/MeetU/api/activity)


- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar，可选参数，如果带token则会对is_participated进行判断，默认为false，同时会对该用户与活动之间的距离做出返回，默认为0km|调用接口凭证|
>|type|int，可选参数|活动类型，1为精心计划，2为说走就走|
>|school_id|int，可选参数|学校id，由创建者的学校决定|
>|numberOfPeople|int，可选参数|返回最大人数少于此变量的所有活动|
>|page|int，可选参数|分页，默认一页展示20个|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Varchar|信息|
>|total|Integer|返回活动总数|
>|creator|object|创建者信息|
>|data|object|活动列表|
>|data.type|int|1为精心计划，2为说走就走|
>|data.people_number_up|Integer|参与上限人数|
>|data.people_number_join|Integer|已参与人数|
>|data.PercentOfPeople|float|参与人数/人数上限，保留两位小数四舍五入|
>|data.status|varchar|活动当前状态，根据当前时间和报名截止时间判断|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 20,
    "data": [
        {
            "id": 78,
            "title": "一起玩",
            "content": "一起玩一起玩一起玩",
            "creator": {
                "id": 44,
                "nickname": "哈喽",
                "avatar": "/public/uploads/avatars/default_man.png",
                "age": null,
                "character_value": 50,
                "gender": "男",
                "followers_count": 0,
                "description": "吃货"
            },
            "people_number_up": 10,
            "people_number_join": 1,
            "type": 2,
            "entrie_time_start": "2017-06-08 10:46:42",
            "entrie_time_end": "2017-06-08 20:46:42",
            "date_time_start": null,
            "date_time_end": null,
            "location": "一棵树观景台",
            "lat": "29.550935",
            "lng": "106.60911",
            "group_id": null,
            "created_at": "1天前",
            "updated_at": "1天前",
            "is_participated": false,
            "distance": null,
            "status": "报名已经结束",
            "PercentOfPeople": 0.1,
            "activity_users": [
                {
                    "id": 44,
                    "avatar": "/public/uploads/avatars/default_man.png"
                }
            ],
            "tags": [
                "随便玩"
            ]
        },
    ]
}
```

#### 接口说明 2、获取单个活动

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity/{activity_id}](https://xbbbbbb.cn/MeetU/api/activity/{activity_id})


- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|token|varchar，可选参数，如果带token则会对is_participated进行判断，默认为false，同时会对该用户与活动之间的距离做出返回，默认为0km|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Integer|信息|
>|activity|object|活动信息数组|
>|is_participated|bool|该授权用户是否参与该活动|
>|status|bool|根据entrie_time_start来判断该活动状态|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "data": {
        "id": 78,
        "title": "一起玩",
        "content": "一起玩一起玩一起玩",
        "creator": {
            "id": 44,
            "nickname": "哈喽",
            "avatar": "/public/uploads/avatars/default_man.png",
            "age": null,
            "character_value": 50,
            "gender": "男",
            "followers_count": 0,
            "description": "吃货"
        },
        "people_number_up": 10,
        "people_number_join": 1,
        "type": 2,
        "entrie_time_start": "2017-06-08 10:46:42",
        "entrie_time_end": "2017-06-08 20:46:42",
        "date_time_start": null,
        "date_time_end": null,
        "location": "一棵树观景台",
        "lat": "29.550935",
        "lng": "106.60911",
        "group_id": null,
        "created_at": "1天前",
        "updated_at": "1天前",
        "is_participated": false,
        "distance": null,
        "status": "报名已经结束",
        "PercentOfPeople": 0.1,
        "tags": [
            "随便玩"
        ],
        "users": [
            {
                "id": 44,
                "nickname": "哈喽",
                "avatar": "/public/uploads/avatars/default_man.png",
                "age": null,
                "character_value": 50,
                "gender": "男",
                "followers_count": 0,
                "description": "吃货"
            }
        ]
    }
}
```

#### 接口说明 3、获取活动参与成员列表

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity/{activity_id}/participants](https://xbbbbbb.cn/MeetU/api/activity/{activity_id}/participants)


- **请求方式** 
>**GET**

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|信息|
>|total|Integer|返回活动总数|
>| user|   object|  用户列表|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 2,
    "users": [
        {
            "id": 2,
            "nickname": "zs",
            "age": null,
            "character_value": 50,
            "gender": null,
            "grade": null,
            "followers": 0,
            "description": null,
            "school": "中国人民大学"
        },
        {
            "id": 4,
            "nickname": "xbb",
            "age": null,
            "character_value": 50,
            "gender": "女",
            "grade": null,
            "followers": 0,
            "description": null,
            "school": "中国矿业大学(北京)"
        }
    ]
}
```

#### 接口说明 4、创建活动

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity](https://xbbbbbb.cn/MeetU/api/activity)


- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|**token**|varchar|调用接口凭证|
>|title|varchar，必须，切不超过100个字符|标题
>|content|varchar，必须|内容|
>|type|int，必须|活动类型|
>|people_number_up|int，可选参数，若没有则为0，代表无人数上线|人数上限|
>|location|varchar|地点|
>|group_id|int|群聊组id|
>|entrie_time_start|datetime|报名起始时间|
>|entrie_time_end|datetime|报名截止时间|
>|date_time_start|datetime|活动开始时间|
>|date_time_end|datetime|活动结束时间|
>|tags|array|标签数组，由标签名组成|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Varchar|信息|
>|activity|object|所创建的活动|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "success",
  "data": {
    "id": 11,
    "title": "五一厦门三日游",
    "content": "活动介绍活动介绍活动介绍",
    "creator": {
      "id": 1,
      "name": "陈旭斌"
    },
    "people_number_up": 20,
    "people_number_join": 0,
    "type": 1,
    "entrie_time_start": null,
    "entrie_time_end": null,
    "date_time_start": null,
    "date_time_end": null,
    "location": "厦门鼓浪屿",
    "created_at": "2017-04-20 18:26:00",
    "updated_at": "2017-04-20 18:26:00",
    "tags": []
  }
}
```

#### 接口说明 5、更新活动

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity/{activity_id}](https://xbbbbbb.cn/MeetU/api/activity/)

 **注意：只能更新自己创建的活动**

- **请求方式** 
>**PUT**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|**token**|varchar|调用接口凭证|
>|title|varchar|标题
>|content|varchar|内容|
>|type|int|活动类型|
>|people_number_up|int|人数上限|
>|location|varchar|地点|
>|entrie_time_start|datetime|报名起始时间|
>|entrie_time_end|datetime|报名截止时间|
>|date_time_start|datetime|活动开始时间|
>|date_time_end|datetime|活动结束时间|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Varchar|信息|
>|activity|object|所创建的活动|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "success",
  "data": {
    "id": 11,
    "title": "五一厦门三日游",
    "content": "活动介绍活动介绍活动介绍",
    "creator": {
      "id": 1,
      "name": "陈旭斌"
    },
    "people_number_up": "35",
    "people_number_join": 0,
    "type": "说走就走",
    "entrie_time_start": null,
    "entrie_time_end": null,
    "date_time_start": null,
    "date_time_end": null,
    "location": "厦门鼓浪屿",
    "created_at": "2017-04-20 18:26:00",
    "updated_at": "2017-04-20 18:26:30",
    "tags": []
  }
}
```

#### 接口说明 6、删除活动

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity/{activity_id}](https://xbbbbbb.cn/MeetU/api/activity/{activity_id})

 **注意：只能删除自己创建的活动**

- **请求方式** 
>**DELETE**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|**token**|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Varchar|信息|
>|activity|object|所创建的活动|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "删除成功",
}
```

#### 接口说明 7、参加活动

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity/{activity}/participants ](https://xbbbbbb.cn/MeetU/api/activity/{activity}/participants)


- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|**token**|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Varchar|信息|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "参加成功"
}
```

#### 接口说明 8、退出活动

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity/{activity}/participants ](https://xbbbbbb.cn/MeetU/api/activity/{activity}/participants)


- **请求方式** 
>**DELETE**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|**token**|varchar|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Varchar|信息|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "退出成功"
}
```

#### 接口说明 9、获取用户参加的活动列表

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity/user_participated/{id}](https://xbbbbbb.cn/MeetU/api/activity/user_participated/{id})


- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|id|int|用户id|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Varchar|信息|
>|activity|object|活动|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 1,
    "data": [
        {
            "id": 1,
            "title": "五一厦门三日游",
            "content": "活动介绍活动介绍活动介绍",
            "creator": 1,
            "people_number_limit": 25,
            "people_number_up": 35,
            "people_number_join": 0,
            "type": "说走就走",
            "entrie_time_start": null,
            "entrie_time_end": null,
            "date_time_start": null,
            "date_time_end": null,
            "location": "厦门鼓浪屿",
            "created_at": "2017-04-20 21:28:11",
            "updated_at": "2017-04-21 00:00:51",
            "tags": [
                "说走就走",
                "桌游"
            ]
        }
    ]
}
```

#### 接口说明 10、获取用户创建的活动列表

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/activity/user_created/{id}](https://xbbbbbb.cn/MeetU/api/activity/user_created/{id})


- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|id|int|用户id|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|Varchar|信息|
>|activity|object|活动|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 1,
    "data": [
        {
            "id": 2,
            "title": "火锅",
            "content": "活动介绍",
            "creator": 20,
            "people_number_limit": 2,
            "people_number_up": 4,
            "people_number_join": 1,
            "type": "说走就走",
            "entrie_time_start": null,
            "entrie_time_end": null,
            "date_time_start": "2017-04-18 18:10:51",
            "date_time_end": "2017-04-18 19:30:56",
            "location": "城门老火锅",
            "created_at": "2017-04-18 09:11:36",
            "updated_at": "2017-04-18 09:11:38",
            "tags": []
        }
    ]
}
```

## 搜索模块

#### 接口说明 1、模糊查询学校

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/search/schools](https://xbbbbbb.cn/MeetU/api/search/schools)

- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|q|varchar|全文检索的关键词|
>|start|int|起始元素|
>|count|int|返回结果的数量，默认为20|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|total|int|查询结果个数|
>|data|object|返回信息|
>|data:school_id|int|学校id|
>|data:school_name|varchar|学校名称|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 3,
    "data": [
        {
            "school_id": 1,
            "school_name": "中国人民大学"
        },
        {
            "school_id": 22,
            "school_name": "中国人民公安大学"
        },
        {
            "school_id": 167,
            "school_name": "中国人民武装警察部队学院"
        }
    ]
}
```

#### 接口说明 2、用户信息查询

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/search/users](https://xbbbbbb.cn/MeetU/api/search/users)

- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|q|varchar|全文检索的关键词|
>|start|int|起始元素|
>|count|int|返回结果的数量，默认为20|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|object|用户迷你信息|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "data": [
        {
            "id": 4,
            "nickname": "xbb",
            "age": null,
            "character_value": 50,
            "gender": "女",
            "grade": null,
            "description": null,
            "school": "中国矿业大学(北京)"
        },
        {
            "id": 6,
            "nickname": "xbb",
            "age": null,
            "character_value": 50,
            "gender": "女",
            "grade": null,
            "description": null,
            "school": null
        },
        {
            "id": 7,
            "nickname": "xbb",
            "age": null,
            "character_value": 50,
            "gender": "女",
            "grade": null,
            "description": null,
            "school": "中国人民大学"
        }
    ]
}
```

#### 接口说明 3、获取省份列表

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/provinces](https://xbbbbbb.cn/MeetU/api/provinces)


- **请求方式** 
>**GET**

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>| data|object|  省份列表|
>|province_id|int|省份id|
>|province_name|varchar|省份名称|

- **返回示例**
>    
```json
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
> [https://xbbbbbb.cn/MeetU/api/schools ](https://xbbbbbb.cn/MeetU/api/schools)


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
>| data|object|  学校列表|
>|data:school_id|int|学校id|
>|data:school_name|varchar|学校名称

- **返回示例**
>    
```json
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

#### 接口说明 5、活动信息查询

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/search/activities](https://xbbbbbb.cn/MeetU/api/search/activities)

- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|q|varchar|全文检索的关键词|
>|token|varchar，可选参数，如果带token则会对is_participated进行判断，默认为false|调用接口凭证|
>|start|int|起始元素|
>|count|int|返回结果的数量，默认为20|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|activity|object|活动实例|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 2,
    "data": [
        {
            "id": 1,
            "title": "五一厦门三日游",
            "content": "活动介绍活动介绍活动介绍",
            "creator": {
                "id": 1,
                "nickname": "XB",
                "avatar": "/images/avatars/default.png",
                "age": 19,
                "character_value": 50,
                "gender": "男",
                "followers": 0,
                "description": null,
                "school": "重庆邮电大学"
            },
            "people_number_limit": 25,
            "people_number_up": 35,
            "people_number_join": 1,
            "type": "说走就走",
            "entrie_time_start": "2017-04-28 00:01:09",
            "entrie_time_end": "2017-04-30 00:01:11",
            "date_time_start": null,
            "date_time_end": null,
            "location": "厦门鼓浪屿",
            "created_at": "2017-04-20 21:28:11",
            "updated_at": "2017-04-21 00:00:51",
            "is_participated": true,
            "status": "活动已经结束",
            "tags": {
                "1": "电影",
                "2": "桌游"
            }
        },
        {
            "id": 8,
            "title": "五一厦门三日游",
            "content": "活动介绍活动介绍活动介绍1",
            "creator": {
                "id": 3,
                "nickname": "kubiXB",
                "avatar": "/images/avatars/default.png",
                "age": null,
                "character_value": 50,
                "gender": "男",
                "followers": 1,
                "description": null,
                "school": "天津商业大学"
            },
            "people_number_limit": 25,
            "people_number_up": 35,
            "people_number_join": 3,
            "type": "说走就走",
            "entrie_time_start": null,
            "entrie_time_end": null,
            "date_time_start": null,
            "date_time_end": null,
            "location": "厦门鼓浪屿",
            "created_at": "2017-04-22 10:28:51",
            "updated_at": "2017-04-27 22:12:40",
            "is_participated": false,
            "status": "活动已经结束",
            "tags": []
        }
    ]
}
```

#### 接口说明 6、搜索标签

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/search/tags ](https://xbbbbbb.cn/MeetU/api/search/tags)


- **请求方式** 
>**GET**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|q| varchar| 标签关键词|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>| data|object|标签信息|

- **返回示例**
>    
```json
{
    "tags": [
        {
            "id": 1,
            "name": "电影"
        }
    ]
}
```

## 发现模块

#### 接口说明 1、获取最新发现内容

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/moments](https://xbbbbbb.cn/MeetU/api/moments)

- **请求方式** 
>**GET**
- **此方法按时间进行排序**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|page|int，可选参数|分页，默认一页展示20个|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|total|int|查询结果个数|
>|data|object|返回信息|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 2,
    "data": [
        {
            "id": 4,
            "title": "厦门，一个容易触动人心的地方",
            "content": "本次厦门行可以说是一场蓄谋已久的旅行，几个月前就和胖州商量着：要不要再报名试试，一起跑个马拉松？",
            "location": "重庆邮电大学",
            "votes_count": "0",
            "comments_count": "0",
            "user_id": "1",
            "created_at": "14分钟前",
            "updated_at": "14分钟前",
            "user": {
                "id": 1,
                "nickname": "XB",
                "age": 19,
                "avatar": "/public/uploads/avatars/1.jpg",
                "character_value": 50,
                "school_name": "重庆邮电大学",
                "gender": "男",
                "grade": "大二",
                "description": "运动健儿",
                "followers_count": 0,
                "last_lat": "29.538065",
                "last_lng": "106.614548"
            }
        }....
    ]
}
```

#### 接口说明 2、获取关注者的发现内容

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/moments/followings](https://xbbbbbb.cn/MeetU/api/moments/followings)

- **请求方式** 
>**GET**
- **此方法按发布时间进行排序，内容为关注的人的发现内容**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|**token**|varchar|调用接口凭证|
>|page|int，可选参数|分页，默认一页展示20个|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|total|int|查询结果个数|
>|data|object|返回信息|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "total": 2,
    "data": [
        {
            "id": 4,
            "title": "厦门，一个容易触动人心的地方",
            "content": "本次厦门行可以说是一场蓄谋已久的旅行，几个月前就和胖州商量着：要不要再报名试试，一起跑个马拉松？",
            "location": "重庆邮电大学",
            "votes_count": "0",
            "comments_count": "0",
            "user_id": "1",
            "created_at": "14分钟前",
            "updated_at": "14分钟前",
            "user": {
                "id": 1,
                "nickname": "XB",
                "age": 19,
                "avatar": "/public/uploads/avatars/1.jpg",
                "character_value": 50,
                "school_name": "重庆邮电大学",
                "gender": "男",
                "grade": "大二",
                "description": "运动健儿",
                "followers_count": 0,
                "last_lat": "29.538065",
                "last_lng": "106.614548"
            }
        }....
    ]
}
```

#### 接口说明 3、创建发现内容

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/moments](https://xbbbbbb.cn/MeetU/api/moments)

- **请求方式** 
>**POST**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|**token**|string|调用接口凭证|
>|title|string，必须|标题|
>|content|string，必须|内容|
>|location|string|发布时的位置|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|total|int|查询结果个数|
>|data|object|返回发现实例|

- **返回示例**
>    
```json
{
  "status_code": 2000,
  "info": "success",
  "data": {
    "title": "美国明尼阿波利斯吉他四重奏音乐会 官方售票",
    "content": "— 英国《古典吉他》杂志\n明尼阿波利斯吉他四重奏自1986年成立以来，以其非凡的想象力、卓越的艺术技巧和音乐性，成为当今“世界上最重要的吉他组合之一”——《共鸣板（Soundboard）》杂志\n四位吉他演奏家——约瑟夫·哈格多恩（Joseph Hagedorn）、玛娅·拉多范利亚（Maja Radovanlija）、本·坎克尔（Ben Kunkel）和维德·欧登（Wade Oden)的大多数乐曲都是背谱演奏，这在吉他组合中是不多见的。他们的曲目不仅有吉他四重奏的原创作品也有他们自己的精彩改编，除了众多重要的委约新作品还有独特的跨界合作。他们的演奏有着清晰的线条、独特的声音和绝对的纯净。作曲家兼演奏家丹尼尔·伯纳德·罗梅因（Daniel Bernard Roumain）曾评价他们，“不只是一支吉他四重奏，不只是出众的音乐家，也不只是一支非常棒的室内乐组合”，“他们是声音、风格和实质的使者”。",
    "location": "重庆邮电大学",
    "votes_count": 0,
    "comments_count": 0,
    "user_id": 7,
    "updated_at": "1秒前",
    "created_at": "1秒前",
    "id": 7
  }
}
```

#### 接口说明 4、获取单个发现内容

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/moments/{moments_id}](https://xbbbbbb.cn/MeetU/api/moments/{moments_id})

- **请求方式** 
>**GET**


- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|varchar|返回信息|
>|data|object|返回信息|

- **返回示例**
>    
```json
{
    "status_code": "2000",
    "info": "success",
    "data": {
        "id": 7,
        "title": "美国明尼阿波利斯吉他四重奏音乐会 官方售票",
        "content": "— 英国《古典吉他》杂志\n明尼阿波利斯吉他四重奏自1986年成立以来，以其非凡的想象力、卓越的艺术技巧和音乐性，成为当今“世界上最重要的吉他组合之一”——《共鸣板（Soundboard）》杂志\n四位吉他演奏家——约瑟夫·哈格多恩（Joseph Hagedorn）、玛娅·拉多范利亚（Maja Radovanlija）、本·坎克尔（Ben Kunkel）和维德·欧登（Wade Oden)的大多数乐曲都是背谱演奏，这在吉他组合中是不多见的。他们的曲目不仅有吉他四重奏的原创作品也有他们自己的精彩改编，除了众多重要的委约新作品还有独特的跨界合作。他们的演奏有着清晰的线条、独特的声音和绝对的纯净。作曲家兼演奏家丹尼尔·伯纳德·罗梅因（Daniel Bernard Roumain）曾评价他们，“不只是一支吉他四重奏，不只是出众的音乐家，也不只是一支非常棒的室内乐组合”，“他们是声音、风格和实质的使者”。",
        "location": null,
        "votes_count": "0",
        "comments_count": "0",
        "user_id": "7",
        "created_at": "3分钟前",
        "updated_at": "3分钟前",
        "user": {
            "id": 7,
            "nickname": "xbb",
            "age": 20,
            "avatar": "/public/uploads/avatars/default.png",
            "character_value": 50,
            "school_name": "中国人民大学",
            "gender": "女",
            "description": "运动健儿",
            "followers_count": 1,
            "last_lat": "29.538065",
            "last_lng": "106.614548"
        }
    }
}
```

#### 接口说明 4、删除发现内容

- **请求URL**
> [https://xbbbbbb.cn/MeetU/api/moments/{moments_id}](https://xbbbbbb.cn/MeetU/api/moments/{moments_id})

- **请求方式** 
>**DELETE**

- **请求参数**
> | 请求参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>|**token**|string|调用接口凭证|

- **返回**
> | 返回参数      |     参数类型 |   参数说明   |
>| :-------- | :--------| :------ |
>| status_code|   Integer|  执行结果code|
>|info|string|返回信息|
>|data|object|返回信息|

- **返回示例**
>    
```json
{
  "status_code": "2000",
  "info": "操作成功"
}
```