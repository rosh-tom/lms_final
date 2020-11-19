<div class="container">
            <footer class="footer"> 
                <p class="text-center">
                    Account: 
                    <label for="">
                        <?= $user_info['firstname'] ." ". $user_info['lastname']?> 
                         | 
                         <span>
                             <?= $user_info['types'] ?>
                         </span>
                         | 
                        <span>
                            <a href="../../controller/logout.controller.php">Logout</a>
                        </span>
                        
                    </label>
                </p>
                <p class="text-center">2020 &copy; SDSSU Cantilan Learning Management System.</p>

            </footer>
        </div>
    </body>
</html>