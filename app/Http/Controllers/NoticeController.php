<?php
namespace App\Http\Controllers;

class NoticeController extends Controller{
	public function noticeList($noticeType = null, $pageNumber = 0) {
		if(!$noticeType || !isset(config('app.typeIds')[$noticeType])) {
			return redirect('/notice/newest');
		}

		$offsetNumber = $pageNumber * 20;

		if ($pageNumber < 0) {
			$limit = 20;
		} else {
			$limit = $offsetNumber . ', ' . 20;
		}

		$data = [];
		$data['subName'] = config('app.typeIds')[$noticeType]['navName'];
		$data['subtype'] = $noticeType;
		$data['topics'] = getTopicsByType($noticeType, $limit);
		$data['pageNumber'] = $pageNumber;

		$countTopics = count(getTopicsByType($noticeType));
		$data['nextButtonFlag'] = (($countTopics - $offsetNumber) > 20) ?  true : false;

		if ($countTopics < $offsetNumber) {
			return redirect('/notice/' . $noticeType);
		}

		$content = view('notice.list', $data);

		return response($content, 200);
	}

	public function topic($topicId = null) {
		if(strlen($topicId) !== 32) {
			return redirect('/notice/newest');
		}

		$data = [];
		$data['topicInfo'] = getTopicById($topicId);

		if(!$data['topicInfo']) {
			return redirect('/notice/newest');
		}

		$content = view('notice.topic', $data);

		return response($content, 200);
	}
}