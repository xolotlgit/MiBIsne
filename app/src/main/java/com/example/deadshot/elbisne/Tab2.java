package com.example.deadshot.elbisne;

import android.content.Context;
import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.TextInputEditText;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

public class Tab2 extends Fragment {
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private String mParam1;
    private String mParam2;
    private OnFragmentInteractionListener mListener;


    public static TextInputEditText CorreoNego,SitioNego,faceNego,TuiwerNego,InstagramNego,OtraRNego,TagsNego;

    public Tab2() {
        // Required empty public constructor
    }
    public static Tab2 newInstance(String param1, String param2) {
        Tab2 fragment = new Tab2();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        //return inflater.inflate(R.layout.fragment_tab2, container, false);
        View rootView = inflater.inflate(R.layout.fragment_tab2, container, false);

        CorreoNego = (TextInputEditText)rootView.findViewById(R.id.txtCorreoNego);
        SitioNego = (TextInputEditText)rootView.findViewById(R.id.txtSitioWebNego);
        faceNego = (TextInputEditText)rootView.findViewById(R.id.txtFacebookNego);
        TuiwerNego = (TextInputEditText)rootView.findViewById(R.id.txtTwitterNego);
        InstagramNego = (TextInputEditText)rootView.findViewById(R.id.txtInstagramNego);
        OtraRNego = (TextInputEditText)rootView.findViewById(R.id.txtOtraRedNego);
        TagsNego = (TextInputEditText)rootView.findViewById(R.id.txtTagsNego);

        return rootView;
    }

    // TODO: Rename method, update argument and hook method into UI event
    public void onButtonPressed(Uri uri) {
        if (mListener != null) {
            mListener.onFragmentInteraction(uri);
        }
    }
    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        if (context instanceof OnFragmentInteractionListener) {
            mListener = (OnFragmentInteractionListener) context;
        } else {
            throw new RuntimeException(context.toString()
                    + " must implement OnFragmentInteractionListener");
        }
    }
    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
    }
    public interface OnFragmentInteractionListener {
        // TODO: Update argument type and name
        void onFragmentInteraction(Uri uri);
    }
}
