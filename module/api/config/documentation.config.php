<?php
return array(
    'api\\V1\\Rest\\Visits\\Controller' => array(
        'entity' => array(
            'description' => 'Details for a visit to the museum using the Audio Guide',
            'GET' => array(
                'response' => '{
   "_links": {
       "self": {
           "href": "/visits[/:visits_id]"
       }
   }

}',
                'description' => 'The response generated.',
            ),
            'POST' => array(
                'request' => '{

}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/visits[/:visits_id]"
       }
   }

}',
            ),
        ),
        'collection' => array(
            'GET' => array(
                'response' => '{
   "_links": {
       "self": {
           "href": "/visits"
       },
       "first": {
           "href": "/visits?page={page}"
       },
       "prev": {
           "href": "/visits?page={page}"
       },
       "next": {
           "href": "/visits?page={page}"
       },
       "last": {
           "href": "/visits?page={page}"
       }
   }
   "_embedded": {
       "visits": [
           {
               "_links": {
                   "self": {
                       "href": "/visits[/:visits_id]"
                   }
               }
              "email": "The email address",
              "stops": "The stops on the visit to the museum",
              "started": "The start time for the visit",
              "ended": "The end time for the visit"
           }
       ]
   }
}',
                'description' => 'Get a list of visit data.',
            ),
            'description' => 'This collection of results will allow for pagination through the data.',
        ),
        'description' => 'An API endpoint to collect data from the British Museum audio guide hardware.',
    ),
);
