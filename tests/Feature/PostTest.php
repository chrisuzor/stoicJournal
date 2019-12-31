<?php

namespace Tests\Feature;

use App\BlogPost;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testNoBlogPostsText()
    {

        $response = $this->get('/posts');
        $response->assertSeeText('No Blog Posts Yet');
    }

    public function testSeeOneBlogPostWhenThereIsOne(){
        //Arrange

        $post = $this->createDummyPost();

        //Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New Title');

        $this->assertDatabaseHas('blog_posts',[
            'title' => 'New Title'
        ]);
    }

    public function testStoreValid(){
        $params = [
            'title' => 'Valid title',
            'content' => 'Valid Content of 10 Characters'
        ];

        $this->post('/posts',$params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        $this->assertEquals(session('status'),'Blog Post was created');
    }

    public function testStoreFails(){
        $params = [
            'title' => 'X',
            'content' => 'X'
        ];

        $this->post('/posts',$params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid(){

        $post = $this->createDummyPost();
        $this->assertDatabaseHas('blog_posts',$post->toArray());
        $params = [
            'title' => 'A New Title',
            'content' => 'A new blog post has been updated'
        ];

        $this->put("/posts/{$post->id}",$params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog Post was updated');
        $this->assertDatabaseMissing('blog_posts',$post->toArray());
    }

    public function testDeletePost(){
        $post = $this->createDummyPost();
        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog Post was deleted');
        $this->assertDatabaseMissing('blog_posts',$post->toArray());
    }

    private function createDummyPost(): BlogPost{
        $post = new BlogPost();
        $post->title = 'New Title';
        $post->content = 'Content of Blog Post';
        $post->save();

        return $post;
    }
}
