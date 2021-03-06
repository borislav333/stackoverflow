<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }
    public function getAvatarAttribute(){
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    public function favorites(){
        return $this->belongsToMany(Question::class,'favorites','user_id','question_id')->withTimestamps();
    }
    public function voteQuestions(){
        return $this->morphedByMany(Question::class,'votable');
    }
    public function voteAnswers(){
        return $this->morphedByMany(Answer::class,'votable');
    }
    public function voteQuestion(Question $question,$vote){
        $voteQuestions=$this->voteQuestions();
        if($voteQuestions->where('votable_id',$question->id)->exists()){
            $voteQuestions->updateExistingPivot($question,['vote'=>$vote]);
        }
        else{
            $voteQuestions->attach($question,['vote'=>$vote]);
        }
        $question->load('votes');
        $downVotes=(int)$question->votes()->wherePivot('vote',-1)->sum('vote');
        $upVotes=(int)$question->votes()->wherePivot('vote',1)->sum('vote');
        $question->votes_count=$upVotes+$downVotes;
        $question->save();
    }
    public function voteAnswer(Answer $answer,$vote){
        $voteAnswer=$this->voteAnswers();
        if($voteAnswer->where('votable_id',$answer->id)->exists()){
            $voteAnswer->updateExistingPivot($answer,['vote'=>$vote]);
        }
        else{
            $voteAnswer->attach($answer,['vote'=>$vote]);
        }
        $answer->load('votes');
        $downVotes=(int)$answer->votes()->wherePivot('vote',-1)->sum('vote');
        $upVotes=(int)$answer->votes()->wherePivot('vote',1)->sum('vote');
        $answer->votes_count=$upVotes+$downVotes;
        $answer->save();
    }
}
