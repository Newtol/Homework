
	// 接口集合
	var _api = {

		//注册登录注销
		register: "http://115.159.113.116/index.php/Login/insert",
		login: "http://115.159.113.116/index.php/Login/isvalid",
		quit: "http://115.159.113.116/index.php/Login/quit",
		//个人信息展示
		showInfo: "http://115.159.113.116/index.php/User/perInfo/",
		//信息修改
		editInfo: "http://115.159.113.116/index.php/User/modiSelf",


		//班级搜索
		searchClass: "http://115.159.113.116/index.php/Clazz/serClass/",
		//学生创建班级
		createClass: "http://115.159.113.116/index.php/Clazz/creaClass",

		//请求加入班级
		joinApply: "http://115.159.113.116/index.php/Clazz/appClass",

		//老师班级列表
		teaClassList: "http://115.159.113.116/index.php/Clazz/haveClass",
		//请求某个班的学生
		getStu: "http://115.159.113.116/index.php/Clazz/oneClass/",

		//学生课程列表
		stuCourseList: "http://115.159.113.116/index.php/Clazz/inCourse",
		//学生已加入班级列表
		stuClassList: "http://115.159.113.116/index.php/Clazz/inClass",





		//老师查看作业列表
		teaWorkList: "http://115.159.113.116/index.php/Homework/noDueHo",		
		//查看学生完成的作业
		computeWork: "http://115.159.113.116/index.php/Homework/hoPerson/",
		//老师批改作业
		teaCorrecting: "http://115.159.113.116/index.php/Homework/hoJudge",
		//发布作业
		declareWork: "http://115.159.113.116/index.php/Homework/sirUpload",
		//某个学生的作业得分情况
		stuWorkDetail: "http://115.159.113.116/index.php/Homework/getStatistc/",



		//学生查看作业列表
		stuWorkList: "http://115.159.113.116/index.php/Homework/getNodue",
		//学生查看自己的作业详情
		stuSelfwork: "http://115.159.113.116/index.php/Homework/getHo/",
		//提交作业
		submitWork: "http://115.159.113.116/index.php/Homework/stuUpload/1",
		//已经上传过作业，再次覆盖
		editWork: "http://115.159.113.116/index.php/Homework/stuUpload/2",
		


		//消息列表
		announceList: "http://115.159.113.116/index.php/Message/getMess",
		//消息详情
		announceDetail: "http://115.159.113.116/index.php/Message/getDetail/",
		//发送公告
		sendAnnounce: "http://115.159.113.116/index.php/Message/postMessage",

		//管理员查看申请
		applyList: "http://115.159.113.116/index.php/Clazz/showApply/",
		//同意老师申请
		agreeTea: "http://115.159.113.116/index.php/Clazz/okApply/1",
		//同意同学申请
		agreeStu: "http://115.159.113.116/index.php/Clazz/okApply/2",
		// 拒绝老师或者同学的申请
		refuseApply: "http://115.159.113.116/index.php/Clazz/defuseApply",

		// 查看何时加入这个系统：
		whenjoin: "http://115.159.113.116/index.php/Analy/whenjoin/2",
		//查看哪门老师可获得平时成绩最高
		whichHigh: "http://115.159.113.116/index.php/Analy/whichHigh",
		// 当年结果统计（只有先点过这个接口，才会有当年的结果，建议在点数据分析按钮时就触发这个接口一次）
		analyYear: "http://115.159.113.116/index.php/Analy/analyYear",
		// 返回当年获得的最高的平时分课和最低平时分课以及交了多少次作业和没有交多少次作业
		bestBad: "http://115.159.113.116/index.php/Analy/bestBad"

	};

