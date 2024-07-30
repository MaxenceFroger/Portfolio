package com.example.simon;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        SharedPreferences preferences = getSharedPreferences("Test", Context.MODE_PRIVATE);
        ((TextView)findViewById(R.id.highscore)).setText(Integer.toString(preferences.getInt("highscore",0)));
    }

    public void launchGame(View v) {
        Intent i = new Intent(this,  Game.class);
        startActivity(i);
    }

    public void exit(View v) {finish();}
}