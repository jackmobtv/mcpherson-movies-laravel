import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";
import FavoriteList from "@src/js/components/FavoriteList.jsx";
import ProfileSidebar from "@src/js/components/Profile_Sidebar.jsx"
import ProfileHeader from "@src/js/components/Profile_Header.jsx"

export default function user_favorites({userJSON, favoritesJSON}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const user = userJSON === undefined ? null : JSON.parse(userJSON);
    const favorites = favoritesJSON === undefined ? null : JSON.parse(favoritesJSON);

    useEffect(() => {
        document.title = "";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <main className="py-5">
                <ProfileHeader/>
                <section className="pt-3">
                    <div className="container">
                        <div className="row">
                            <ProfileSidebar user={user}/>

                            <div className="col-lg-9">
                                <div className="card bg-transparent border rounded-3">
                                    <div className="card-header border-bottom">
                                        <h3 className="card-header-title mb-0">Favorites</h3>
                                    </div>

                                    <div className="card-body">
                                        {(user == null) ? (
                                            <h3>User Not Found</h3>
                                        ) : (
                                            <FavoriteList favoriteList={favorites}/>
                                        )}
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


