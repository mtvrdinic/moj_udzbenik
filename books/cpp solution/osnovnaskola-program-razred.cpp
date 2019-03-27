#include <bits/stdc++.h>
#include <iostream> 

using namespace std;

bool linija_ima_dvije_crtice(char s[]){
  
  string k(s);
   
  size_t found = k.find("razred");
  size_t found2 = k.find(";;;;;;;");

  int count = 0;

  for(int i = 0; s[i] != '\0'; i++){
    if(s[i] == '-') count++;
  }

  if(count >= 2  && !isdigit(s[0]) && !isupper(s[1]) && !isupper(s[2])){
    return true;
  }
  else if(found != std::string::npos && found2 != std::string::npos){
    return true;
  }
  else{
    return false;
  }

}

int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];
  
  for(int i = 0; i < 242400; i++){
  	cin.std::istream::getline (s, 1000);
  	if(linija_ima_dvije_crtice(s)){  		
  		cout << i + 1 << "   " << s << endl;
  	}
  }

  return 0;
}