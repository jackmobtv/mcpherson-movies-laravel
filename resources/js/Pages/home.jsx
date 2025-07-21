import {useEffect} from "react";

export default function home({myVar}) {
    useEffect(() => {
        document.title = "Home";
    }, []);

    return (
        <>
            <h1>{myVar}</h1>
        </>
    );
}


