import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";

export default function home({id, title, poster, plot}) {
    const appURL = window.REACT_APP.APP_URL;

    useEffect(() => {
        document.title = "Home";
    }, []);

    return (
        <Layout>
            <div>
                <div className="row justify-content-center">
                    <div className="col-12">
                        <div className="custom-background text-center">
                            <h1 className="text-white">Featured Movie</h1>
                            <img src={poster} alt="poster" className="img-fluid"
                                 id="poster"/>
                            <h3 className="text-white mt-4">{title}</h3>
                            <p className="text-white mx-auto"
                               id="plot">{plot}</p>
                            <a className="btn btn-primary" href={"/view-movies?id=" + {id}}>View Movie</a>
                        </div>
                    </div>
                </div>
            </div>
        </Layout>
    );
}


