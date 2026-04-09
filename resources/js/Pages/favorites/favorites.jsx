import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";
import FavoriteList from "@src/js/components/FavoriteList.jsx";
import Profile_Sidebar from "@src/js/components/Profile_Sidebar.jsx";
import Profile_Header from "@src/js/components/Profile_Header.jsx";

export default function favorites({favoritesJSON}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const favorites = favoritesJSON === undefined ? null : JSON.parse(favoritesJSON);

    useEffect(() => {
        document.title = "Favorites";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <main>
                <Profile_Header/>

                <section className="pt-0">
                    <div className="container">
                        <div className="row">
                            <Profile_Sidebar/>

                            <div className="col-lg-9">
                                <div className="card bg-transparent border rounded-3">
                                    <div className="card-header border-bottom">
                                        <h3 className="card-header-title mb-0">Favorites</h3>
                                    </div>
                                    <div className="card-body">
                                        <FavoriteList favoriteList={favorites} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </Layout>
    );
}


