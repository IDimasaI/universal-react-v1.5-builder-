import React,{ lazy,Suspense  } from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
const Home=lazy(()=>import('./routers/Home'))

if(document.getElementById('root_home')){
  const root_admp_fits = ReactDOM.createRoot(document.getElementById('root_home'));
    root_admp_fits.render( 
      <React.StrictMode>
        <Suspense fallback={<div>Loading...</div>}>
          <Home />
        </Suspense>
      </React.StrictMode>
    );
}