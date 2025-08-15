<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration {
    protected $connection = 'mongodb';

    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $collection) {
            $collection->jsonSchema(
                schema: [
                    'bsonType' => 'object',
                    'required' => ['user_id', 'title', 'description', 'status'],
                    'properties' => [
                        'user_id' => [
                            'bsonType' => 'objectId',
                            'description' => 'must be a ObjectId and is required',
                        ],
                        'title' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string and is required',
                        ],
                        'description' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string and is required',
                        ],
                        'status' => [
                            'bsonType' => 'string',
                            'description' => 'must be a string and is required',
                        ],
                    ],
                ],
                validationAction: 'error',
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
