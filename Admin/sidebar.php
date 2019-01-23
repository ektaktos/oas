 
<div class = "col-lg-2 well" style = "margin-top:60px;">
				<div class = "container-fluid" style = "word-wrap:break-word;">
					<img src="userfiles/avatars/<?php echo $rws['student_avatar'];?>" class="img-circle"  style="width: 130px;height: 130px;" />
					<br />
					<br />
					<label class = "text-muted"></label> <!-- name of the user to display -->
				</div>
				<hr style = "border:1px dotted #d3d3d3;"/>
				<ul id = "menu" class = "nav menu">
					<li><a style = "font-size:15px; border-bottom:1px solid #d3d3d3;" href="enroll.php"><i class = "glyphicon glyphicon-tasks"></i> Course Module</a>
<!--
						<ul style = "list-style-type:none;">
							<li><a href = "#" style = "font-size:15px;"><i class = "glyphicon glyphicon-user"></i> Admin</a></li>
							<li><a href = "#" style = "font-size:15px;"><i class = "glyphicon glyphicon-user"></i> Student</a></li>
						</ul>
-->
					</li>
					<li><a style = "font-size:15px; border-bottom:1px solid #d3d3d3;" href ="#""><i class = "glyphicon glyphicon-book"></i> Announcement</a></li>
					<li><a style = "font-size:15px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-th"></i> View Scores</a>
<!--
						<ul style = "list-style-type:none;">
							<li><a href = "#" style = "font-size:15px;"><i class = "glyphicon glyphicon-random"></i> Borrowing</a></li>
							<li><a href = "#" style = "font-size:15px;"><i class = "glyphicon glyphicon-random"></i> Returning</a></li>
						</ul>
-->
					</li>
					<li><a style = "font-size:15px; border-bottom:1px solid #d3d3d3;" href = "#"><i class = "glyphicon glyphicon-book"></i> Article Entry</a></li>
					<li><a  style = "font-size:15px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-cog"></i> Settings</a>
						<ul style = "list-style-type:none;">
							<li><a style = "font-size:15px;" href="components/logout.php"><i class = "glyphicon glyphicon-log-out"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>