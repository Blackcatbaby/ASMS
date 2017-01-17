# 电子科技大学ASMS系统
Achievement Scale Management System，用来计算学生的毕业指标达成度的系统。
##整体框架

####服务器端采用PHP开发:
- 采用Laravel框架
- 老战的开发路上第一个使用真正意义上的MVC模式的开发方式的项目。
- 第一次连续肝四天到凌晨
- 第一次使用Composer
- 熟悉了Laravel框架
- 好tmd累

#### 前端使用jQuery框架和Bootstrap框架进行开发
- 主要使用AJAX技术进行前后端的交互。
- Bootstrap用来展现页面

## 相关名词说明
- GR: 毕业要求达成度，其下属有GR子项，如GR1.1、GR1.2等。
- CO: 课程目标达成度
- CM: 课程模块
- CCP: 课程考核点管理，其下属有CCP子项，如CCP1.1、CCP1.2等，分别关联学生平时成绩、期中成绩、实验成绩、期末成绩等。

## 对应关系
GR->GR子项->CO->CCP     