$(document).ready(function() {
	// URL form :: change trigger
	$('input[name="link_type"]').on('change', function() {
		$('div[data-link-type]').slideUp();
		$('div[data-link-type="' + $(this).val() + '"]').slideDown();
	});

	// PARENT :: change trigger
	$('input#make_root').on('change', function() {
		if($(this).is(':checked')) {
			$('select[name="parent_id"]').prop('disabled', true);
			$('div.link_container').slideUp();
		} else {
			$('select[name="parent_id"]').prop('disabled', false);
			$('div.link_container').slideDown();
		}
	});

	// open subnavigation if 3rd-level-element is active
	$('a.collapse-item.active').parent().parent().addClass('show');

	// load plugins
	$('a[data-tooltip]').tooltip();
	$('.icp-auto').iconpicker();
	$('.toast').toast('show');

	$('.toast button[data-dismiss]').click(function(event) {
		var id = $(this).attr('data-id');
		$.ajax({
			url: '/notifications/toggleajax/' + id,
			success: function(result) {
				if(result == '404') {
					console.log('Notification #' + id + ' not found.');
				} else if(result == '500') {
					console.log('Notification #' + id + ' seen-state could not be toggled.');
				}
			}
		});
	});

	tinymce.init({
		selector: 'textarea.tinymce'
	});

	// Settings form
	$('.addNewSetting').click(function(event) {
		event.preventDefault();
		
		var max = 0;
		$('tr[data-settings-num]').each(function() {
			var value = parseInt($(this).data('settings-num'));
			max = (value > max) ? value : max;
		})
		var i = max + 1;
		var $newSetting = `
			<tr data-settings-num="${i}">
				<td>
					<div class="input text">
						<input type="text" class="form-control" placeholder="new_settings_name" name="Settings[${i}][name]" data-settings-num="${i}" />
					</div>
				</td>
				<td>
					<div class="input text">
						<input type="text" class="form-control" placeholder="Settings Value" name="Settings[${i}][value]" />
					</div>
				</td>
				<td>
					<button class="btn btn-danger" data-remove-setting="${i}"><i class="fas fa-trash"></i> Remove</button>
				</td>
			</tr>
		`;
		$('tr.settings_actions').before($newSetting);
	});

	$('form.settings_form').on('click', 'button[data-remove-setting]', function(event){
		event.preventDefault();

		var settingId = $(this).attr('data-remove-setting');
		$('tr[data-settings-num="' + settingId + '"]').remove();
	});

	// fetch notifications via ajax (all 20 seconds)
	setInterval(fetchNotifications, 5000);
});

function fetchNotifications() {
	$.ajax({
		url: '/notifications/livesync',
		success: function(result) {
			var $notificationsContainer = $('div#userNotifications');
			var notificationsCounter = 0;
			$('div#userNotifications a.notification-item').remove();

			var json = JSON.parse(result);
			for (var i = 0; i < json.length; i++) {
				var unread;
				var unreadClass = 'bg-primary';
				if(!json[i].seen) {
					unread = 'unread';
					unreadClass = 'bg-success'
					notificationsCounter++;
				} else {
					unread = '';
				}
				(!json[i].seen) ? unread = 'class="font-weight-bold"' : unread = '';
				var $newNotification = `
					<a class="notification-item dropdown-item d-flex align-items-center" href="/notifications/view/${json[i].id}">
						<div class="mr-3">
							<div class="icon-circle ${unreadClass}">
								<i class="fas fa-file-alt text-white"></i>
							</div>
						</div>
						<div>
							<div class="small text-gray-500">${$.timeago(json[i].created)}</div>
							<span ${unread}>${json[i].title}</span>
							<p class="m-0 lh-1 text-gray-500"><small>${json[i].description}</small></p>
						</div>
					</a>`;

				$notificationsContainer.children('a#showAllUserNotifications').before($newNotification);
			};

			$('span#NotificationsCounter').text(notificationsCounter);
		}
	});
}