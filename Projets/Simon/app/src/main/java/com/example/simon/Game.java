package com.example.simon;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.util.Log;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.Random;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.simon.databinding.ActivityMainBinding;

public class Game extends AppCompatActivity {
    ArrayList<String> test = new ArrayList<String>();
    int difficulty = 0;
    int etape = 0;

    int error = 0;

    public MediaPlayer sonRouge,sonBleu,sonJaune,sonVert,sonError;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_game);
        sonRouge = MediaPlayer.create(Game.this, R.raw.son1);
        sonRouge.setVolume(1.0f , 1.0f);
        sonBleu = MediaPlayer.create(Game.this, R.raw.son2);
        sonBleu.setVolume(1.0f , 1.0f);
        sonJaune = MediaPlayer.create(Game.this, R.raw.son3);
        sonJaune.setVolume(1.0f , 1.0f);
        sonVert = MediaPlayer.create(Game.this, R.raw.son4);
        sonVert.setVolume(1.0f , 1.0f);
        sonError = MediaPlayer.create(Game.this, R.raw.error);
        sonError.setVolume(1.0f , 1.0f);
        new CountDownTimer(1000, 500) {
            public void onTick(long millisUntilFinished) {}
            public void onFinish() {
                addDifficulty();
            }
        }.start();
    }

    public void wait3() {
        long timestampMS = System.currentTimeMillis();
        while(timestampMS+3000 > System.currentTimeMillis()) {}
    }

    public void addDifficulty() {
        difficulty++;
        Random rand = new Random();
        int rand_int1 = rand.nextInt(4);
        switch(rand_int1) {
            case 0:
                test.add("rouge");
                break;
            case 1:
                test.add("bleu");
                break;
            case 2:
                test.add("jaune");
                break;
            case 3:
                test.add("vert");
                break;
        }
        String temp = etape + "/" + difficulty;
        ((TextView)findViewById(R.id.score)).setText(temp);
        display();
    }

    private void changeButtonColor(final View button, final int tempColor, final int originalColor, long delay, long changeTime, boolean displayMode) {
        if(!displayMode) { button.setEnabled(false); }
        button.postDelayed(new Runnable() {
            @Override
            public void run() {
                button.setBackgroundColor(tempColor);
                switch((String)button.getTag()) {
                    case "rouge":
                        sonRouge.start();
                        break;
                    case "bleu":
                        sonBleu.start();
                        break;
                    case "jaune":
                        sonJaune.start();
                        break;
                    case "vert":
                        sonVert.start();
                        break;

                }
                // Schedule the color change back after 2 seconds
                button.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        // Change the button color back
                        button.setBackgroundColor(originalColor);
                        if(!displayMode) { button.setEnabled(true); }
                    }
                }, changeTime); // 2 seconds delay to change back
            }
        }, delay);
    }

    public void display() {
        findViewById(R.id.rouge).setEnabled(false);
        findViewById(R.id.bleu).setEnabled(false);
        findViewById(R.id.jaune).setEnabled(false);
        findViewById(R.id.vert).setEnabled(false);
        ((TextView)findViewById(R.id.phase)).setText("Observer");
        long delay = 0; // Start delay
        long speed = Math.max(1000-(difficulty*100),250);
        for (String tes : test) {
            switch (tes) {
                case "rouge":
                    changeButtonColor(findViewById(R.id.rouge), 0xFFFF4444, 0xFFCC0000, delay,speed,true);
                    break;

                case "bleu":
                    changeButtonColor(findViewById(R.id.bleu), 0xFF00DDFF, 0xFF040477, delay,speed,true);
                    break;

                case "jaune":
                    changeButtonColor(findViewById(R.id.jaune), 0xFFFFFB00, 0xFF919102, delay,speed,true);
                    break;

                case "vert":
                    changeButtonColor(findViewById(R.id.vert), 0xFFA3DA04, 0xFF5D7C02, delay,speed,true);
                    break;
            }
            delay += Math.max(1500-(difficulty*100),750); // Increment delay for next button by 3 seconds
        }
        new CountDownTimer(delay, 500) {
            public void onTick(long millisUntilFinished) {}
            public void onFinish() {
                findViewById(R.id.rouge).setEnabled(true);
                findViewById(R.id.bleu).setEnabled(true);
                findViewById(R.id.jaune).setEnabled(true);
                findViewById(R.id.vert).setEnabled(true);
                ((TextView)findViewById(R.id.phase)).setText("Jouer");
            }
        }.start();
    }

    public void rouge(View v) {
        changeButtonColor(findViewById(R.id.rouge), 0xFFFF4444, 0xFFCC0000, 0,500,false);
        evaluer("rouge");
    }

    public void bleu(View v) {
        changeButtonColor(findViewById(R.id.bleu), 0xFF00DDFF, 0xFF040477, 0,500,false);
        evaluer("bleu");
    }

    public void jaune(View v) {
        changeButtonColor(findViewById(R.id.jaune), 0xFFFFFB00, 0xFF919102, 0,500,false);
        evaluer("jaune");
    }

    public void vert(View v) {
        changeButtonColor(findViewById(R.id.vert), 0xFFA3DA04, 0xFF5D7C02, 0,500,false);
        evaluer("vert");
    }

    public void error() {
        error++;
        switch(error) {
            case 3:
                findViewById(R.id.error3).setVisibility(View.VISIBLE);
            case 2:
                findViewById(R.id.error2).setVisibility(View.VISIBLE);
            case 1:
                findViewById(R.id.error1).setVisibility(View.VISIBLE);
                break;
        }
        if(error>=3) {
            endGame();
        }
    }

    public void endGame() {
        findViewById(R.id.rouge).setEnabled(false);
        findViewById(R.id.bleu).setEnabled(false);
        findViewById(R.id.jaune).setEnabled(false);
        findViewById(R.id.vert).setEnabled(false);
        findViewById(R.id.echec).setVisibility(View.VISIBLE);
        findViewById(R.id.echec).setEnabled(true);

        SharedPreferences preferences = getSharedPreferences("Test", Context.MODE_PRIVATE);
        if(preferences.getInt("highscore",0) < difficulty) {
            SharedPreferences.Editor edit = preferences.edit();
            edit.putInt("highscore", difficulty);
            edit.apply();
            Log.d("Cekass",Integer.toString(preferences.getInt("highscore",0)));
        }
    }

    public void leave(View v) {
        Intent i = new Intent(this,  MainActivity.class);
        startActivity(i);
    }

    public void evaluer(String s) {
        if(s == test.get(etape)) {
            etape++;
            String temp = etape + "/" + difficulty;
            ((TextView)findViewById(R.id.score)).setText(temp);
            if(etape > difficulty-1) {
                findViewById(R.id.rouge).setEnabled(false);
                findViewById(R.id.bleu).setEnabled(false);
                findViewById(R.id.jaune).setEnabled(false);
                findViewById(R.id.vert).setEnabled(false);
                new CountDownTimer(1000, 500) {
                    public void onTick(long millisUntilFinished) {}
                    public void onFinish() {
                        addDifficulty();
                    }
                }.start();
                etape = 0;
            }
        }
        else {
            sonError.start();
            error();
            etape = 0;
            String temp = etape + "/" + difficulty;
            ((TextView)findViewById(R.id.score)).setText(temp);
        }
    }
}