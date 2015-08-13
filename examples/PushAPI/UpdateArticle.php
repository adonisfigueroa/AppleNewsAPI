<?php

/**
 * @file
 * Example: POST Article
 */

require '../../src/PushAPI.php';

use \ChapterThree\AppleNews;

$api_key_id = "";
$api_key_secret = "";
$endpoint = "https://endpoint_url";

$PushAPI = new PushAPI(
  $api_key_id,
  $api_key_secret,
  $endpoint
);

// An optional metadata part may also be included, to provide additional
// non-Native data about the article. The metadata part also specifies any
// sections for the article, by URL. If this part is omitted,
// the article will be published to the channel's default section.
$metadata =  [
  'data' => [
    'isSponsored' => true,
    'links' => [
      'sections' => [
        'https://endpoint_url/sections/{your_section_id}',
      ],
    ],
    'revision' => REVISION_ID // required.
  ],
];

// Updates an existing article.
// See $response variable to get a new revision ID.
$response = $PushAPI->post('/articles/{article_id}',
  [
    'article_id' => ARTICLE_ID
  ],
  [
    // required. Apple News Native formatted JSON string.
    'json' => '{"version":"0.10.13","identifier":"10","title":"Test article","language":"en","layout":{"columns":7,"width":1024},"components":[{"text":"Test article content\n\n","format":"markdown","role":"body"},{"URL":"bundle:\/\/article.jpg","role":"photo"}],"componentTextStyles":{"default":{}}}',
    // List of files to POST
    'files' => [
      'bundle://article.jpg' => __DIR__ . '/files/article.jpg',
    ], // optional
    // JSON metadata string
    'metadata' => json_encode($metadata, JSON_UNESCAPED_SLASHES), // optional
  ]
);
