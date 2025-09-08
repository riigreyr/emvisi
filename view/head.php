<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Peta - BelanjaYuk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    .container {
      flex: 1 0 auto;
    }

    main {
  flex: 1 0 auto; /* ini yang penting */
}
    footer {
      flex-shrink: 0;
    }

    .bg-blue-dark {
      background-color: #0b3d91 !important;
      color: white !important;
    }
    #map {
      width: 800px;
      height: 250px;
      border-radius: 0.5rem;
    }

    /* Container foto & info di kanan */
    #infoPanel {
      width: 400px;
      padding-left: 15px;
    }
    #infoPanel img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 0.5rem;
      user-select: none;
      pointer-events: none;
      box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
    #infoText {
      margin-top: 10px;
      font-weight: 600;
      color: #0b3d91;
      min-height: 50px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
      #map, #infoPanel {
        width: 100% !important;
        height: auto !important;
      }
      #infoPanel img {
        height: auto !important;
      }
    }

     .slideshow-img {
      width: 100%; height: 350px; object-fit: cover; border-radius: 8px;
    }
    .carousel-caption-custom {
      position: absolute; bottom: 10px; left: 15px;
      background-color: rgba(0, 0, 0, 0.5); color: white;
      padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;
    }
    .card-header { font-weight: bold; }
    footer {
      background: #e9ecef; text-align: center;
      padding: 1.5rem 0; font-size: 0.9rem; color: #333;
    }
    .card-equal-height { height: 100%; }
    .bg-blue-dark { background-color: #0b3d91 !important; color: white !important; }
    .btn-blue-dark {
      background-color: #0b3d91; border-color: #0b3d91; color: white;
    }
    .btn-blue-dark:hover {
      background-color: #092f6d; border-color: #092f6d; color: white;
    }
    .custom-klasemen-row { margin-top: 3rem; }

    .main-content {
  margin-top: -40px; 
}

.btn-logout {
  height: 38px;            
  line-height: 24px;       
  display: flex;           
  align-items: center;     
  gap: 5px;                
}

.btn-logout:hover {
  background-color: #f8f9fa; 
  color: #0b3d91;           
}


.nav-tabs .nav-link {
            border-radius: 8px 8px 0 0;
            font-weight: 500;
            color: #555;
        }
        .nav-tabs .nav-link.active {
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            color: #000;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        }


        .btn-add {
            background-color: #4e73df;
            color: #fff;
        }
        .btn-add:hover {
            background-color: #3b5ec9;
            color: #fff;
        }


  </style>
</head>