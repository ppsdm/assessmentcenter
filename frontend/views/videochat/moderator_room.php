<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model frontend\models\Test */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tests'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJsFile(
    '//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js',
//    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJs(
    "
Twilio.Video.createLocalTracks({
       audio: true,
       video: { width: 300 }
    }).then(function(localTracks) {
       return Twilio.Video.connect('$accessToken', {
           name: '$roomName',
           tracks: localTracks,
           video: { width: 300 }
       });
    }).then(function(room) {
    
    $( '#complete' ).click(function() {
//       alert('Chat is completed');
window.location.href='index.php?r=videochat/completeroom&id=$roomId';
});
       console.log('Successfully joined a Room: ', room.name);

       room.participants.forEach(participantConnected);

       var previewContainer = document.getElementById(room.localParticipant.sid);
       if (!previewContainer || !previewContainer.querySelector('video')) {
           participantConnected(room.localParticipant);
       }

       room.on('participantConnected', function(participant) {
        //    console.log(\"Joining: '\"   participant.identity   \"'\");
           participantConnected(participant);
       });

       room.on('participantDisconnected', function(participant) {
        //    console.log(\"Disconnected: '\"   participant.identity   \"'\");
           participantDisconnected(participant);
       });
       
       room.on('disconnected',function() {
       alert('disconnected');
       });

       
    });

function participantConnected(participant) {
   console.log('Participant \"%s\" connected', participant.identity);

   const div = document.createElement('div');
   div.id = participant.sid;
   div.setAttribute(\"style\", \"float: left; margin: 10px;\");
//    div.innerHTML = \"<div style='clear:both'>\" participant.identity \"</div>\";

   participant.tracks.forEach(function(track) {
       trackAdded(div, track)
   });

   participant.on('trackAdded', function(track) {
       trackAdded(div, track)
   });
   participant.on('trackRemoved', trackRemoved);

   document.getElementById('media-div').appendChild(div);
}

function participantDisconnected(participant) {
   console.log('Participant \"%s\" disconnected', participant.identity);

   participant.tracks.forEach(trackRemoved);
   document.getElementById(participant.sid).remove();
}

function trackAdded(div, track) {
   div.appendChild(track.attach());
   var video = div.getElementsByTagName(\"video\")[0];
   if (video) {
       video.setAttribute(\"style\", \"max-width:300px;\");
   }
}

function trackRemoved(track) {
   track.detach().forEach( function(element) { element.remove() });
}

    ",
    View::POS_READY,
    'my-button-handler'
);



?>
<div class="test-view">

    <h1>

    </h1>


    <div class="content">
        <div class="title m-b-md">
            MODERATOR Video Chat Rooms
        </div>
        <div id="media-div">
        </div>
        <div id="control">
            <?php
            echo Html::button('Complete', ['id' => 'complete']);
            ?>
        </div>
    </div>
</div>
