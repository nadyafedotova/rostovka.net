{
	"button": {
		"show": false,
		"text": ""
	},
	"fields": [
		{
			"type": "text",
			"name": "Введите имя",
			"placeholder": "Имя",
			"required": true,
			"sms": false
		},
		{
			"type": "tel",
			"mask": "+38(0xx) xxx-xx-xx",
			"name": "Введите номер:",
			"required": true,
			"sms": false
		},
		{
			"type": "textarea",
			"name": "Введите коментарий:",
			"placeholder": "Добрый день, вы можете выслать мне угги.......",
			"required": false,
			"sms": false
		}
	],

	"form": {
		"template": "vk",
		"title": "Обратная связь",
		"button": "Перезвоните мне",
		"align": "center",
		"welcome": ""
	},
	"alerts": {
		"yes": "Yes",
		"no": "No",
		"process": "Отправка данных...",
		"success": "Ваше сообщение успешно отправлено",
		"fails": {
			"required": "Пожалуйста заполните все поля",
			"sent": "Вы отправляли сообщение менее минуты назад"
		}
	},
	"captcha": {
		"show": true,
		"title": "Проверка",
		"error": "Не правильный ответ"
	},
	"license": {
		"key": "422033305436423430283020423433305122272633304820421830205426",
		"show": true
	},
	"mail": {
		"referrer": "Page referrer",
		"url": "URL",
		"linkAttribute": "Link attribute",
		"smtp": false
	},
	"animationSpeed": 150,
	"sms": {
		"send": false,
		"captions": true,
		"cut": true
	}
}