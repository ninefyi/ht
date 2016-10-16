package com.openworldtravels.www.hypertension;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;

public class MainMenuActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_menu);
    }

    protected void onClickEmergency(View view){

    }

    protected void onClickMedicine(View view){
        Intent intent = new Intent(this, MedicineMainActivity.class);
        startActivity(intent);
    }

    protected void onClickNurse(View view){

    }

    protected void onClickPrivate(View view){

    }
}
